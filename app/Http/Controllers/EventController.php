<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function store()
    {
        $event = [
            'title' => 'Titulo Store ' . rand(1, 200),
            'description'=> 'descricao',
            'body' => 'corpo',
            'slug' => '',
            'start_event' => date('Y-m-d H:i:s')
        ];

        return Event::create($event);
    }

    public function update($event)
    {
        $eventData = [
            'title' => 'Titulo Update ' . rand(1000, 2000),
        ];

        $event = Event::find($event);
        $event->update($eventData);

        return $event;
    }

    public function destroy($event)
    {
        $event = Event::findOrFail($event);
        return $event->delete();
    }
}
