<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function sendContactUsEmail(Request $request)
    {
        \Mail::to('alikashmar8@gmail.com')->send(new \App\Mail\ContactUsEmail($request));
        return response()->json(['message' => 'Email sent successfully']);
    }
}
