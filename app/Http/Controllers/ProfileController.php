<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Alumni::all();
        return view('profile', compact('user'));
    }
}
