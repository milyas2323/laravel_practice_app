<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LivewireController extends Controller
{
    public function index()
    {
        return view('admin.livewirecounter.index');
    }
}
