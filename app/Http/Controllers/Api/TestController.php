<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends BaseController
{

    public function index()
    {
        $user = request()->user();
        dd($user);
    }
}
