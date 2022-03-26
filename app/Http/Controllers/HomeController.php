<?php

namespace App\Http\Controllers;

use App\Events\NewAlbumCreated;
use App\Mail\TestEmail;
use App\Mail\TestMd;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function testMail()
    {
        $user = User::first();
        \Mail::to('coltrida@gmail.com')->send(new TestEmail($user));
        return redirect()->route('index');
    }

    public function testMailMd()
    {
        $user = User::first();
        \Mail::to('coltrida@gmail.com')->send(new TestMd($user));
        return redirect()->route('index');
    }

    public function testEvent()
    {
        $album = Album::first();
        event(new NewAlbumCreated($album));
        return redirect()->route('index');
    }
}
