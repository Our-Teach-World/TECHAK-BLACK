<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = Service::active()->get();
        
        return view('services', compact('services'));
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }
        
        return view('service-detail', compact('service'));
    }
}
