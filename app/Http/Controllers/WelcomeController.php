<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Tournament;
use App\War;
use Illuminate\Support\Facades\DB;
use App\Post;


class WelcomeController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
}
