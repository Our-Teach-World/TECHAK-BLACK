<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index()
    {
        $services = Service::active()->take(6)->get();
        
        return view('home', compact('services'));
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        return view('about');
    }
}
