<?php

namespace App\Http\Controllers\Public;

use App\Models\User;
use App\Library\Enum;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return 'Welcome to public site.';
    }
}
