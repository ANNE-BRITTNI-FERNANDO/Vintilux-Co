<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('admin')->attempt($credentials)) {
            // Success
        } else {
            // Failed login
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        return view('admin.dashboard');
    }

    public function dashboard()
    {
        // Since we're only showing the navigation buttons, we don't need to fetch any data
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminController $adminController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminController $adminController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminController $adminController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminController $adminController)
    {
        //
    }
}
