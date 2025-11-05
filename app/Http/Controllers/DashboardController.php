<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $events = Event::all();
        $numberOfEvent = Event::count();
        $numberOfParticipants = Participant::count();
        $numberOfParticipantsUnpaid = Participant::where('payment_status', 'unpaid')->count();

        return view('dashboard', compact('numberOfEvent', 'numberOfParticipants', 'numberOfParticipantsUnpaid', 'events'));
    }
}
