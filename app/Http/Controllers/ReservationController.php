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
//        dd($reservedTimes);
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
                'slots' => $freeSlots,

            ];
//            dd($freeSlotsByCourt[$court->id]);

        }

        return[
            'freeSlots' => $freeSlotsByCourt,
            'allSlots' => $allSlots,
            'reservedTimes' => $reservedTimes,
        ];
    }


    public function index(Request $request)
    {

        $courtNumbers = Court::pluck('court_number')->toArray();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');

        $datesForWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $datesForWeek[] = $now->copy()->addDays($i)->format('Y-m-d');
        }

        $date = $request->input('date', $today);

        // Fetch future reservations
        $reservations=Reservation::where('date','>=',$now)
            ->orderBy('date')
            ->orderBy('court_id')->get();

        $slotsData = $this->getAvailableSlots($date);
        $allSlots = $slotsData['allSlots'];
        $freeSlotsByCourt = $slotsData['freeSlots'];

//        dd($reservedSlots);
//        dd($reservedSlots);
//        dd($allSlots);
        $allSlotsReal=[];
        for ($i=1;$i<=3;$i++) {
            $allSlotsReal[$i-1] = [
                'court_number' => $i,
                'allSlots' => $allSlots,
            ];
        }

        foreach ($allSlotsReal as &$realSlot) {
            foreach ($freeSlotsByCourt as $freeSlot) {
                if ($realSlot['court_number'] == $freeSlot['court_number']) {
                    foreach($realSlot['allSlots'] as &$slot) {
                        if (!in_array($slot, $freeSlot['slots'])) {
                           $slot['reserved']=true;
                        }
                        else {
                            $slot['reserved'] = false;
                        }
                    }
                }
            }
        }
//        dd($allSlotsReal);

        // Pass the reservedSlots to the view
        return view('reservations.index', compact('reservations', 'courtNumbers','date', 'datesForWeek','allSlotsReal'));
    }
    public function create(Request $request)
    {
        $courtNumber = (int)$request->query('court_number');
        $date1 = Carbon::parse($request->query('date'))->format('Y-m-d');
        $startTime=Carbon::parse($request->query('start_time'))->format('H:i');
        $endTime=Carbon::parse($request->query('end_time'))->format('H:i');


        $courtNumbers = Court::pluck('court_number')->toArray();
        $now = Carbon::now();
        $oneWeekLater = $now->copy()->addWeek();
        $today = $now->format('Y-m-d');
        $datesForWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $datesForWeek[] = $now->copy()->addDays($i)->format('Y-m-d');
        }

        $date = $request->input('date', $today);

        $reservations = Reservation::with('user','court')
            ->whereBetween('date',[$now,$oneWeekLater])->get();

        $slotsData = $this->getAvailableSlots($date);
        $allSlots = $slotsData['allSlots'];
        $freeSlotsByCourt = $slotsData['freeSlots'];

        $allSlotsReal=[];
        for ($i=1;$i<=3;$i++) {
            $allSlotsReal[$i-1] = [
                'court_number' => $i,
                'allSlots' => $allSlots,
            ];
        }

        foreach ($allSlotsReal as &$realSlot) {
            foreach ($freeSlotsByCourt as $freeSlot) {
                if ($realSlot['court_number'] == $freeSlot['court_number']) {
                    foreach($realSlot['allSlots'] as &$slot) {
                        if (!in_array($slot, $freeSlot['slots'])) {
                            $slot['reserved']=true;
                        }
                        else {
                            $slot['reserved'] = false;
                        }
                    }
                }
            }
        }

        $courts = Court::all();
        return view('reservations.create', compact('courts', 'reservations', 'courtNumbers',
            'date', 'date1', 'startTime', 'endTime', 'datesForWeek','allSlotsReal','courtNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {

        $now = Carbon::now();
        $oneWeekLater = $now->copy()->addWeek();
        $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('start_time'));

        if ($startDateTime->isPast()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The reservation time must be in the future.');
        }

        if ($startDateTime->greaterThan($oneWeekLater)) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'The reservation time must be within one week from now.');
        }

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
//        @dd($startTime, $endTime);
        $courtId = $request->input('court_id');
        $date = $request->input('date');

        $overlapExists = Reservation::where('court_id', $courtId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                // Check if the reservation overlaps with the start time
                $query
                    ->whereBetween('start_time', [$startTime, $endTime])
                    ->whereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
//                         Check if the new reservation fully encompasses an existing reservation
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->get();



        if (!$overlapExists->isEmpty()) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'The selected time slot overlaps with an existing reservation.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $courtId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date
        ]);

        return redirect()->route('reservation.show')->with('success', 'Reservation made successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $now = Carbon::now()->startOfDay();
        $user = Auth::user();
        $reservations = Reservation::with('court')
            ->where('date', '>=', $now)
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
        $now = Carbon::now();
        $oneWeekLater = $now->copy()->addWeek();
        $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('start_time'));

        if ($startDateTime->isPast()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The reservation time must be in the future.');
        }

        if ($startDateTime->greaterThan($oneWeekLater)) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'The reservation time must be within one week from now.');
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
