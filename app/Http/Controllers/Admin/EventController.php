<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Category;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class EventController extends Controller
{
    use UploadTrait;
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;

        $this->middleware('user.can.edit.event')->only(['edit', 'update']);
    }

    public function index()
    {
        $events = auth()->user()->events()->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all(['id', 'name']);
        return view('admin.events.create', compact('categories'));
    }

    public function store(EventRequest $request)
    {
        $event = $request->all();

        if ($banner = $request->file('banner')) {
            $event['banner'] = $this->upload($banner, 'events/banner');
        }

        $event = $this->event->create($event);
        $event->owner()->associate(auth()->user());
        $event->save();

        if ($categories = $request->get('categories')) {
            $event->categories()->sync($categories);
        }

        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event)
    {
        $categories = Category::all(['id', 'name']);
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Event $event, EventRequest $request)
    {
        $eventData = $request->all();

        if ($banner = $request->file('banner')) {
            if (Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }
            $eventData['banner'] = $this->upload($banner, 'events/banner');
        }

        $event->update($eventData);

        if ($categories = $request->get('categories')) {
            $event->categories()->sync($categories);
        }

        return redirect()->back();
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index');
    }
}
