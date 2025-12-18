<?php

namespace App\Http\Controllers;
use App\Models\News;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dashboard_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Dashboard';
        $user_count = User::count();
        return view('dashboard.index', compact(
            'title',
            'user_count'
        ));
    }

    public function userDashboard()
    {
        $title = 'Home';
        $properties = Property::where('status', 'Disetujui')->orderBy('count_click', 'DESC')->limit(10)->get();
        $news = News::orderBy('id', 'DESC')->limit(10)->get();
        return view('dashboard.userDashboard', compact(
            'title',
            'properties',
            'news',
        ));
    }

    public function ownerDashboard()
    {
        $title = 'Home';
        $news = News::orderBy('id', 'DESC')->get();
        return view('dashboard.ownerDashboard', compact(
            'title',
            'news',
        ));
    }
}
