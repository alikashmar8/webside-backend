<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class UsersController extends Controller
{
    public function sendContactUsEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }
        Mail::to('contact@webside.com.au')->send(new \App\Mail\ContactUsEmail($request->all()));
        return response()->json(['message' => 'Email sent successfully']);
    }
}
