<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Library\Response;


class CacheController extends Controller
{
    public function clear()
    {

        try{
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');
            \Artisan::call('optimize:clear');
            return redirect()->back()->with('success',  __('Cache Cleared Successfully'));
       } catch (\Exception $e){
            return back()->with('error', __('Something went wrong, please try again.'));
       }
    }
}
