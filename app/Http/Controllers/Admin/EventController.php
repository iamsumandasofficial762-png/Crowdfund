<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->latest('event_date')
            ->latest()
            ->paginate(12);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create', [
            'event' => new Event(),
            'categories' => Event::categoryOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Event::uniqueSlug($data['title']);

        if ($request->hasFile('event_image')) {
            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event = Event::create($data);

        AdminActivity::create([
            'title' => 'New Event Created',
            'message' => $event->title.' was created in the admin panel.',
            'type' => 'event',
            'created_by' => auth()->user()->name ?? 'Admin',
        ]);

        return redirect()->route('admin.events.index')->with('status', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', [
            'event' => $event,
            'categories' => Event::categoryOptions(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Event::uniqueSlug($data['title'], $event->getKey());

        if ($request->hasFile('event_image')) {
            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }

            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('status', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->event_image) {
            Storage::disk('public')->delete($event->event_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(Event::categorySlugs())],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'full_description' => ['nullable', 'string'],
            'event_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'event_date' => ['nullable', 'date'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'organizer_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in([Event::STATUS_DRAFT, Event::STATUS_PUBLISHED])],
        ]);
    }
}
