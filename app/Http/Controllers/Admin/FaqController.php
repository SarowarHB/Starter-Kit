<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FAQ\CreateRequest;
use App\Http\Requests\Admin\FAQ\UpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Services\Admin\FaqService;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    use ApiResponse;

    private $faq_service;

    function __construct(FaqService $faq_service)
    {
        $this->faq_service = $faq_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status']);
            return $this->faq_service->dataTable($filter_request);
        }
        return view('admin.pages.website.faq.index');
    }

    public function showCreateForm()
    {
        return view('admin.pages.website.faq.create');
    }

    public function create(CreateRequest $request)
    {
        // dd($request->validated());
        $result = $this->faq_service->createFaq($request->validated());
        if($result)
            return redirect()->route('admin.website.faq.index')->with('success', $this->faq_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->faq_service->message);
    }

    public function show(Faq $faq)
    {
        return view('admin.pages.website.faq.show', [
            'faq'  => $faq,
        ]);
    }

    public function showUpdateForm(Faq $faq)
    {
        return view('admin.pages.website.faq.update', [
            'faq' => $faq
        ]);
    }

    public function update(Faq $faq, UpdateRequest $request)
    {
        abort_unless($faq , 404);
        $result = $this->faq_service->updateFaq($faq, $request->validated());
        if($result)
            return redirect()->route('admin.website.faq.index')->with('success', $this->faq_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->faq_service->message);
    }

    public function changeStatusApi(Faq $faq)
    {
        $faq->is_active = !$faq->is_active;
        $faq->save();

        if($faq)
            return back()->with('success', __('Successfully updated'));
        else
            return back()->with('error', 'Unable to update now');
    }

    public function deleteApi(Faq $faq)
    {
        $faq->delete();

        if($faq)
            return redirect()->route('admin.website.faq.index')->with('success', __('Successfully Deleted'));
        else
            return back()->with('error', 'Unable to delete now');
    }
}
