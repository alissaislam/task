<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show user dashboard
     */
    public function index(): View
    {
        return view('dashboard');
    }
}