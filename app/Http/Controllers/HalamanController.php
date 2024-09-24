<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;

class HalamanController extends Controller
{
    public function index() {

        if (Auth::user()) {
            $role = Auth::user()->role;

            if ($role == 'Admin BKK') {
                return redirect()->route('dashboardadmin');
            } else if ($role == 'Perusahaan') {
                return redirect()->route('dashboardperusahaan');
            } else if ($role == 'Alumni') {
                $alumni = Alumni::all();
                return redirect()->route('dashboardalumni');
            }
        }
        return redirect()->route('login');
    }
}