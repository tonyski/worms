<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function profile()
    {
        return auth()->user();
    }
}
