<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function index()
    {
        $byCategory = request()->has('category')
            ? Category::whereSlug(request()->get('category'))->first()->events()
            : null;


        $events = $this->event->getEventsHome($byCategory)->paginate(15);


        // $events = [];
        return view('home', compact('events'));
    }

    public function show(Event $event)
    {
        // $event = $this->event->whereSlug($event)->first();
        return view('event', compact('event'));
    }
}
