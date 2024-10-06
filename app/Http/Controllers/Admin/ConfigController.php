<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use DataTables;
use App\Models\User;
use App\Library\Enum;
use App\Models\Config;
use App\Library\Helper;
use App\Library\Response;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Components\Email\EmailFactory;
use Illuminate\Support\Facades\Artisan;
use App\Library\Services\Admin\ConfigService;
use App\Library\Services\Admin\EmployeeService;
use App\Http\Requests\Admin\Config\SocialLinkRequest;
use App\Http\Requests\Admin\Config\EmailSettingsRequest;
use App\Http\Requests\Admin\EmailTemplates\UpdateRequest;
use App\Http\Requests\Admin\Config\GeneralSettingsRequest;

class ConfigController extends Controller
{
    use ApiResponse;
    private $config_service;

    function __construct(ConfigService $config_service)
    {
        $this->config_service = $config_service;
    }

    public function dropdownMenu()
    {
        return view('admin.pages.config.dropdown.list');
    }

    public function dropdowns(Request $request, $dropdown)
    {
        $values = $this->config_service::getDropdowns($dropdown);
        return view('admin.pages.config.dropdown.index', [
            'dropdown' => $dropdown,
            'data' => $values
        ]);
    }

    public function createDropdownApi(Request $request, $dropdown)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $values =   $this->config_service::getDropdowns($dropdown);
        if (in_array($request->name, $values)) {
            return Response::error(__($request->name . ' already exists.'));
        }

        $values[] = $request->name;
        $result = $this->config_service->updateConfig($dropdown, json_encode($values, true));

        if($result)
            return $this->response($result, "Successfully Created");

        return back()->withInput($request->all())->with('error', $this->config_service->message);
    }

    public function updateDropdownApi(Request $request, $dropdown, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $values = $this->config_service::getDropdowns($dropdown);
        $tmp_values = $values;
        unset($tmp_values[$id]);
        if (in_array($request->name, $tmp_values)) {
            return Response::error(__($request->name . ' already exists.'));
        }

        $old_name = $values[$id];
        $values[$id] = $request->name;
        $result = $this->config_service->updateConfig($dropdown, json_encode($values, true));
        if($old_name != $request->name)
        {
            if($dropdown == Enum::CONFIG_DROPDOWN_EMP_DESIGNATION)
                EmployeeService::updateByDesignation($old_name, ['designation' => $request->name]);
            /*
            else if($dropdown == Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE)
                Notification::updateByType($old_name, ['type' => $request->name]);
            */
        }
        if($result)
            return $this->response($result, $this->config_service->message);

        return back()->withInput($request->all())->with('error', "Successfully Updated");
    }

    public function deleteDropdownApi($dropdown, $id)
    {
        $values = $this->config_service::getDropdowns($dropdown);
        array_splice($values, intval($id), 1);

        $result = $this->config_service->updateConfig($dropdown, json_encode($values, true));
        if($result)
            return $this->response($result, "Successfully Deleted");

        return back()->with('error', $this->config_service->message);
    }

    public function emailTemplates(Request $request)
    {
        if ($request->ajax()) {
            $data = EmailTemplate::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $user_role = User::getAuthUserRole();
                    return $user_role->hasPermission('config_email_templete_update') ? '<a class="btn btn2-secondary btn-sm" href="' . route('admin.config.email_template.update', $row->id) . '"> <i class="far fa-edit"></i> Edit</a>' : '';
                })
                ->editColumn('updated_at',function($row){
                    return $row->updated_at->format('d-m-Y H:i A');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.config.email_template.index');
    }

    public function updateEmailTemplateForm(EmailTemplate $email_template)
    {
        $shortcodes = explode(',', $email_template->shortcodes);
        $systemShortCodes = Enum::systemShortcodesWithValues();
        return view('admin.pages.config.email_template.update',[
            'data'              => $email_template,
            'shortcodes'        => $shortcodes,
            'systemShortCodes'  => $systemShortCodes,
        ]);
    }

    public function updateEmailTemplate(EmailTemplate $email_template, UpdateRequest $request)
    {
        $data = $request->validated();
        $email_template->update([
            'subject' => $data['subject'],
            'message' => $data['message']
        ]);
        return back()->with('success', __('Successfully Updated'));
    }

    public function general()
    {
        return view('admin.pages.config.general_settings', [
            'countries'     => Helper::getCountries(),
        ]);
    }
    
    public function updateGeneralSettings(GeneralSettingsRequest $request)
    {
       $data = $request->validated();

       if (isset($data['logo'])) {
           $data['logo'] = Helper::uploadImage($data['logo'], Enum::CONFIG_IMAGE_DIR, 200, 200);
       }
       
       if (isset($data['favicon'])) {
           $data['favicon'] = Helper::uploadImage($data['favicon'], Enum::CONFIG_IMAGE_DIR, 16, 16);
       }       
       
       if (isset($data['og_image'])) {
           $data['og_image'] = Helper::uploadImage($data['og_image'], Enum::CONFIG_IMAGE_DIR, 100, 100);
       }

       $this->updateConfig($data);

       return back()->with('success', __('Successfully Updated'));
    }
    
    public function emailSettings()
    {
        return view('admin.pages.config.email_settings');
    }    
    
    public function updateEmailSettings(EmailSettingsRequest $request)
    {
        $data = $request->validated();

        $this->updateConfig($data);

        return back()->with('success', __('Successfully Updated'));
    }

    /**
     * Update config data
     *
     * @param array $data
     * 
     * @return void
     */
    protected function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            Config::where('key', $key)->update(['value' => $value]);
        }

        Artisan::call('cache:clear');
    }

    /**
     * Send email for testing
     *
     * @param Request $request
     */
    public function sendTestMail(Request $request)
    {
        $subject = 'Testing Email';
        $message = 'This is a test email, <br> please ignore if you are not meant to be get this email.';

        try {
            $emailDetails = [
                'email'   => $request->email,
                'subject' => $subject,
                'body'    => $message,
            ];

            (new EmailFactory())->initializeEmail($emailDetails);

            return back()->with('success', __('You will receive a test email soon'));
       } catch (Throwable $e) {
           Log::error($e->getMessage());

            return back()->with('error', __('please check your email settings'));
       }
    }

    public function socialLink()
    {
        return view('admin.pages.config.social_link');
    }

    public function updateSocialLink(SocialLinkRequest $request)
    {
        $data = $request->validated();

        $this->updateConfig($data);

        return back()->with('success', __('Successfully Updated'));
    }
}
