<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function users()
    {
        // Tutti gli utenti con o senza album - left join
        $users = User::with('albums')->get();

        // Gli utenti con album - inner join
        //$users = User::with('albums')->whereHas('albums')->get();

        // Gli utenti che non hanno album - left join
        //$users = User::with('albums')->whereDoesntHave('albums')->get();

        return view('user.index', compact('users'));
    }
}
