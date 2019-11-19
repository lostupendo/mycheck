<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class MyCheckAuthController
 *
 * @package App\Http\Controllers
 */
class MyCheckAuthController extends Controller
{
    /**
     * Display Login page
     *
     * @return View
     */
    public function login() {
        return view('login');
    }

    /**
     * Display registration page
     *
     * @param Request $request
     * @return mixed
     */
    public function register() {
        return view('register');
    }
}
