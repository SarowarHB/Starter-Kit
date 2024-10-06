<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Blog;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class BlogService extends BaseService
{

    private function filter(array $params)
    {
        $query = Blog::select('*');
        if (isset($params['is_deleted']) && $params['is_deleted'] == 1) {
            $query->onlyTrashed();
        }
        else if(isset($params['status'])){
            $query->where('status', $params['status']);
        }
        return $query->get();
    }


    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.website.blog.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.website.blog.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
        }
        else{
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        '.$actionHtml.'
                    </div>
                </div>';
    }

    public function dataTable(array $filter_params)
    {
        $data = $this->filter($filter_params);
        return DataTables::of($data)
                ->addIndexColumn()
                
                ->addColumn('title', function($row){
                    return '<a href="' . route('admin.website.blog.show', $row->id) . '">'.$row->title.'</a>';
                })
                
                ->addColumn('blog_type', function($row){
                    return ucwords($row->blog_type);
                })
                
                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['title', 'blog_type', 'action'])
                ->make(true);
    }

    public function createBlog(array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            if(isset($data['featured_image'])){
                $data['featured_image'] = Helper::uploadImage($data['featured_image'], Enum::BLOG_FEATURE_IMAGE, 800, 500);
            }
            if(isset($data['tags'])){
                $data['tags'] = json_encode($data['tags'], true);
            }

            Blog::create($data);
            return $this->handleSuccess('Successfully Created');

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateBlog(Blog $blog, array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;

            if(isset($data['featured_image'])){
                $data['featured_image'] = Helper::uploadImage($data['featured_image'], Enum::BLOG_FEATURE_IMAGE, 800, 500);
            }
            if(isset($data['tags'])){
                $data['tags'] = json_encode($data['tags'], true);
            }

            $blog->update($data);
            return $this->handleSuccess('Successfully Updated');
        }catch(Exception $e){
            return $this->handleException($e);
        }
    }

    public static function countBlogCategory()
    {
        $categories = [];
        $query = Blog::select('blog_type', DB::raw('count(*) as total'));
        $data = $query->groupBy('blog_type')->pluck('total', 'blog_type')->toArray();
        $total = ConfigService::getDropdowns(Enum::CONFIG_DROPDOWN_BLOG_TYPE);

        foreach($total as $key => $value){
            $categories[$value] = $data[$value] ?? 0;
        }
        return $categories;
    }
}
