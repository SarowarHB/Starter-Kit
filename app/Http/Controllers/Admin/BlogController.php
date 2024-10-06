<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\CreateRequest;
use App\Http\Requests\Admin\Blog\UpdateRequest;
use App\Http\Traits\ApiResponse;
use App\Library\Enum;
use App\Library\Services\Admin\BlogService;
use App\Library\Services\Admin\ConfigService;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    use ApiResponse;

    private $blog_service;

    function __construct(BlogService $blog_service)
    {
        $this->blog_service = $blog_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);
            return $this->blog_service->dataTable($filter_request);
        }
        return view('admin.pages.website.blog.index');
    }

    public function showCreateForm()
    {
        return view('admin.pages.website.blog.create', [
            'blog_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_BLOG_TYPE),
            'tags'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TAGS_TYPE),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->blog_service->createBlog($request->validated());
        if($result)
            return redirect()->route('admin.website.blog.index')->with('success', $this->blog_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->blog_service->message);
    }

    public function show(Blog $blog)
    {
        return view('admin.pages.website.blog.show', [
            'blog'  => $blog,
        ]);
    }

    public function showUpdateForm(Blog $blog)
    {
        return view('admin.pages.website.blog.update', [
            'blog'  => $blog,
            'blog_type'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_BLOG_TYPE),
            'tags'  => ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_TAGS_TYPE),
        ]);
    }

    public function update(Blog $blog, UpdateRequest $request)
    {
        abort_unless($blog , 404);
        $result = $this->blog_service->updateBlog($blog, $request->validated());
        if($result)
            return redirect()->route('admin.website.blog.index')->with('success', $this->blog_service->message);
        else
            return back()->withInput(request()->all())->with('error', $this->blog_service->message);
    }

    public function changeStatusApi(Blog $blog)
    {
        $blog->update([
            'status' => $blog->status == Enum::BLOG_ACTIVE ? Enum::BLOG_INACTIVE : Enum::BLOG_ACTIVE,
        ]);

        if($blog)
            return back()->with('success', __('Successfully Updated'));
        else
            return back()->with('error', 'Unable to create now');
    }

    public function deleteApi(Blog $blog)
    {
        $blog->delete();

        if($blog)
            return redirect()->route('admin.website.blog.index')->with('success', __('Successfully Deleted'));
        else
            return back()->with('error', 'Unable to delete now');
    }
}
