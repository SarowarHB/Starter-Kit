<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\EmailSignature;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\EmailSignature\EmailSignatureStoreRequest;
use App\Http\Requests\Admin\EmailSignature\EmailSignatureUpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Services\Admin\BlogService;
use App\Library\Services\Admin\EmailSignatureService;

class EmailSignatureController extends Controller
{
    use ApiResponse;

    private $email_signature_service;

    function __construct(EmailSignatureService $email_signature_service)
    {
        $this->email_signature_service = $email_signature_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->email_signature_service->dataTable();
        }
        return view('admin.pages.config.email_signature.index');
    }

    public function showCreateForm(): View
    {
        return view('admin.pages.config.email_signature.create');
    }

    public function create(EmailSignatureStoreRequest $request): RedirectResponse
    {
        $result = $this->email_signature_service->createEmailSignature($request->validated());

        if($result)
            return redirect()->route('admin.config.email_signature.index')->with('success', $this->email_signature_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->email_signature_service->message);
    }

    public function show(EmailSignature $emailSignature)
    {
        return $emailSignature;
    }

    public function showUpdateForm(EmailSignature $emailSignature): View
    {
        return view('admin.pages.config.email_signature.update', [
            'emailSignature' => $emailSignature
        ]);
    }

    public function update(EmailSignatureUpdateRequest $request, EmailSignature $emailSignature): RedirectResponse
    {
        $result = $this->email_signature_service->updateEmailSignature($emailSignature, $request->validated());

        if($result)
            return redirect()->route('admin.config.email_signature.index')->with('success', $this->email_signature_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->email_signature_service->message);
    }

    public function deleteApi(EmailSignature $emailSignature): RedirectResponse
    {
        $result = $emailSignature->delete();

        if($result)
            return redirect()->route('admin.config.email_signature.index')->with('success', __('Successfully Deleted'));
        else
            return back()->with('error', 'Unable to delete now');
    }
}
