<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
        return view('Propertytype.home');
    }

    public function create() {

        $this->middleware('auth');
        echo 'sdf';
    }

    public function sendEmail(){

        \Mail::send('email.verified_link', array('content' => 'TEST EMAIL CONTENT'), function($email) {
            $email->to('amarjit@codelee.com')->subject('Test Email');
        });

        if(\Mail::failures()){
            echo 'Email Not Send';
        }else{
            echo 'Email Send';
        }
    }
}
