<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tests = Test::with('questions')->get();
        return view('admin.qustions', compact('tests'));
    }
}
