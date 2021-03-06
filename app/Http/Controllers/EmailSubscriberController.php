<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscriber;
use Illuminate\Http\Request;
use Validator;

class EmailSubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailSubscribers = EmailSubscriber::all();
        return response()->json([$emailSubscribers], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'email.unique' => 'Email already subscribed!',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:email_subscribers,email',
        ], $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        EmailSubscriber::create($request->all());

        return response()->json(['message' => 'Email subscribed successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailSubscriber  $emailSubscriber
     * @return \Illuminate\Http\Response
     */
    public function show(EmailSubscriber $emailSubscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailSubscriber  $emailSubscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailSubscriber $emailSubscriber)
    {
        //
        return response()->json([$emailSubscriber], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailSubscriber  $emailSubscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailSubscriber $emailSubscriber)
    {
        //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:email_subscribers,email',
            'is_subscribed' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $emailSubscriber->update($request->all());

        return response()->json(['message' => 'Subscription updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailSubscriber  $emailSubscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailSubscriber $emailSubscriber)
    {
        //
        $emailSubscriber->delete();
        return response()->json(['message' => 'Subscription deleted successfully'], 201);
    }
}
