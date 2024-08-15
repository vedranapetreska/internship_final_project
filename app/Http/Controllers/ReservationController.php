<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Services\TimeSlotService;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $timeSlotService;
    public function __construct(TimeSlotService $timeSlotService){
        $this->timeSlotService = $timeSlotService;
    }

    protected function getAvailableSlots($date)
    {
        $startTime = '07:00';
        $endTime = '22:00';
        $allSlots = $this->timeSlotService->generateTimeSlots($startTime, $endTime);
        $reservedTimes = Reservation::where('date', $date)->get(['court_id', 'start_time', 'end_time']);
        $freeSlotsByCourt = [];

        $courts = Court::all();
        foreach ($courts as $court) {
            $freeSlots = [];
            $courtReservedTimes = $reservedTimes->where('court_id', $court->id);

            foreach ($allSlots as $slot) {
                $isFree = true;
                foreach ($courtReservedTimes as $reserved) {
                    if ($this->timeSlotService->isOverlapping($slot, $reserved)) {
                        $isFree = false;
                        break;
                    }
                }
                if ($isFree) {
                    $freeSlots[] = $slot;
                }
            }

            $freeSlotsByCourt[$court->id] = [
                'court_number' => $court->court_number,
                'slots' => $freeSlots
            ];
        }
        return $freeSlotsByCourt;
    }


    public function index(Request $request)
    {
        $now = Carbon::now();

        // Get today's date
        $today = $now->format('Y-m-d');

        // Calculate dates for the next week
        $datesForWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $datesForWeek[] = $now->copy()->addDays($i)->format('Y-m-d');
        }

        $date = $request->input('date', $today);

        // Fetch future reservations
        $reservations = Reservation::with(['user', 'court'])
            ->where(function($query) use ($now) {
                $query->where('date', '>', $now->format('Y-m-d'))
                    ->orWhere(function($query) use ($now) {
                        $query->where('date', $now->format('Y-m-d'))
                            ->where('start_time', '>', $now->format('H:i:s'));
                    });
            })
            ->orderBy('date')
            ->orderBy('court_id')
            ->get();

        // Default to today's date if not provided

        // Fetch available slots
        $freeSlotsByCourt = $this->getAvailableSlots($today);

        return view('reservations.index', compact('reservations', 'freeSlotsByCourt', 'date', 'datesForWeek'));
    }
    public function create(Request $request)
    {
        $now = Carbon::now();

        // Get today's date
        $today = $now->format('Y-m-d');

        // Calculate dates for the next week
        $datesForWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $datesForWeek[] = $now->copy()->addDays($i)->format('Y-m-d');
        }

        $date = $request->input('date', $today);

        // Fetch only future reservations with related user and court data
        $reservations = Reservation::with(['user', 'court'])
            ->where(function($query) use ($now) {
                $query->where('date', '>', $now->format('Y-m-d'))
                    ->orWhere(function($query) use ($now) {
                        // For reservations on the current date, check if the start_time is in the future
                        $query->where('date', $now->format('Y-m-d'))
                            ->where('start_time', '>', $now->format('H:i:s'));
                    });
            })
            ->orderBy('date')
            ->orderBy('court_id')
            ->get();

        $freeSlotsByCourt = $this->getAvailableSlots($today);


        $courts = Court::all();
        return view('reservations.create', compact('courts', 'reservations', 'date', 'datesForWeek', 'datesForWeek', 'freeSlotsByCourt'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {

        $validated = request()->validated();

        // Combine date and start_time to create a full datetime
        $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('start_time'));

        // Ensure that the reservation is in the future
        if ($startDateTime->isPast()) {
            return redirect()->back()->with('error', 'The reservation time must be in the future.');
        }

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $courtId = $request->input('court_id');
        $date = $request->input('date');

        $overlapExists = Reservation::where('court_id', $courtId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                // Check if the reservation overlaps with the start time
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        // Check if the new reservation fully encompasses an existing reservation
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($overlapExists) {
            return redirect()->back()->with('error', 'The selected time slot overlaps with an existing reservation.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $courtId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date
        ]);

        return redirect()->back()->with('success', 'Reservation made successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $reservations = Reservation::with('court')
            ->where('user_id', $user->id)
            ->orderBy('date')
            ->orderBy('court_id')
            ->get();

        return view('reservations.show', compact('reservations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $courts = Court::all();
        $reservation = Reservation::with('user', 'court')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('reservations.edit', compact('reservation', 'courts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, Reservation $reservation)
    {

       $validated = request()->validated();

        $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('start_time'));

        // Ensure that the reservation is in the future
        if ($startDateTime->isPast()) {
            return redirect()->back()->with('error', 'The reservation time must be in the future.');
        }

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $courtId = $request->input('court_id');
        $date = $request->input('date');

        $overlapExists = Reservation::where('court_id', $courtId)
            ->where('id', '!=', $reservation->id) // Exclude the current reservation
            ->where('date', $date) // Ensure the reservation is on the same date
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($overlapExists) {
            return redirect()->back()->with('error', 'The selected time slot overlaps with an existing reservation.');
        }

        $reservation->update([
            'court_id' => $courtId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date
        ]);

        // Redirect back with a success message
        return redirect()->route('reservation.show')->with('success', 'Reservation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        // Redirect
        return redirect()->route('reservation.show')->with('success', 'Reservation deleted successfully!');
    }
}
