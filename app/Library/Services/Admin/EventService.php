<?php


namespace App\Library\Services\Admin;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\Event;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class EventService extends BaseService
{
    private function filter(array $params)
    {
        $query = Event::select('*');
        if(isset($params['status'])){
            $query->where('is_active', $params['status']);
        }
        return $query->get();
    }

    private function actionHtml($row)
    {
        $actionHtml = '';

        if($row->id){
            $actionHtml = '<a class="dropdown-item text-primary" href="' . route('admin.website.event.show', $row->id) . '" ><i class="fas fa-eye"></i> View</a>
            <a class="dropdown-item" href="' . route('admin.website.event.update', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
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
                    return '<a href="' . route('admin.website.event.show', $row->id) . '">'.$row->title.'</a>';
                })

                ->addColumn('event_type', function($row){
                    return ucwords($row->event_type);
                })

                ->addColumn('start', function($row){
                    $start = strtotime( $row->start );
                    return date('d-m-Y', $start);
                })

                ->addColumn('end', function($row){
                    $end = strtotime( $row->end );
                    return date('d-m-Y', $end);
                })

                ->addColumn('action', function($row){
                    return $this->actionHtml($row);
                })
                ->rawColumns(['title', 'event_type', 'action'])
                ->make(true);
    }

    public function createEvent(array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            if(isset($data['featured_image'])){
                $data['featured_image'] = Helper::uploadImage($data['featured_image'], Enum::EVENT_FEATURE_IMAGE, 200, 200);
            }
            Event::create($data);
            return $this->handleSuccess('Successfully Created');

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function updateEvent(Event $event, array $data): bool
    {
        try {
            $data['created_by'] = User::getAuthUser()->id;
            if(isset($data['featured_image'])){
                $data['featured_image'] = Helper::uploadImage($data['featured_image'], Enum::EVENT_FEATURE_IMAGE, 200, 200);
            }
            $event->update($data);
            return $this->handleSuccess('Successfully Updated');

        }catch(Exception $e){
            return $this->handleException($e);
        }
    }
}
