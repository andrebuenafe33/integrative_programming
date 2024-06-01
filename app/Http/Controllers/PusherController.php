<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\PusherBroadcast;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class PusherController extends Controller
{
    public function index()
    {
        return view('admin.pusher.index');
    }

    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        return view('admin.pusher.broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        return view('admin.pusher.receive', ['message' => $request->get('message')]);
    }
}
