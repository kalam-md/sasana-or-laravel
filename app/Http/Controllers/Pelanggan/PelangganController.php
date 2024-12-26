<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();

        return view('pelanggan.index', [
            'users' => $users
        ]);
    }
}
