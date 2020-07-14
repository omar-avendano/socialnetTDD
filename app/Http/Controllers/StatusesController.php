<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function store(){

        $status=Status::create([
            'body'=>request('body'),
            'user_id'=>auth()->id()
            ]);

            //return redirect('/');
        return response()->json([
            'body'=>$status->body
        ]);
    }
}
