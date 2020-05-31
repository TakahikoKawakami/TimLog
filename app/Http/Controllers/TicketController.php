<?php

namespace App\Http\Controllers;

class TicketController extends Controller
{
    public function __construct() {

    }

    public function index()
    {
        $data = ['name'=>'hello'];
        return view('index-bootstrap')->with(["data"=>$data]);
    }
}
