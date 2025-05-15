<?php

namespace App\Http\Controllers;

use function view;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index ():View
    {
        return view('home', [
            'posts' => Post::where('user_id', Auth::id())->get()
        ]);
    }
}
