<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Mail\NewReservation;
use App\Mail\ReservationDenied;
use App\Models\Court;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Services\TimeSlotService;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    protected $reservationService;
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index(Request $request)
    {
        $courtNumbers = Court::pluck('court_number')->toArray();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $datesForWeek = $this->reservationService->generateDatesForWeek($now);

        $date = $request->input('date', $today);

        $reservations=Reservation::where('date','>=',$now)
            ->orderBy('date')
            ->orderBy('court_id')->get();

        $availableSlots = $this->reservationService->getAvailableSlots($date);
        $allSlotsReal = $availableSlots['allSlots'];

        return view('reservations.index', compact('reservations', 'courtNumbers', 'date', 'datesForWeek', 'allSlotsReal'));
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

        $datesForWeek = $this->reservationService->generateDatesForWeek($now);
        $date = $request->input('date', $today);

        $reservations = Reservation::with('user','court')
            ->whereBetween('date',[$now,$oneWeekLater])->get();

        $availableSlots = $this->reservationService->getAvailableSlots($date);
        $allSlotsReal = $availableSlots['allSlots'];

        $courts = Court::all();
        return view('reservations.create', compact('courts', 'reservations', 'courtNumbers',
            'date', 'date1', 'startTime', 'endTime', 'datesForWeek','allSlotsReal','courtNumber'));
    }

    public function store(ReservationRequest $request)
    {

        $now = Carbon::now();
        $oneWeekLater = $now->copy()->addWeek();
        $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('start_time'));
        $endDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('end_time'));

        if ($startDateTime->isPast() || $endDateTime->isPast()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The reservation time must be in the future.');
        }

        if ($now->between($startDateTime, $endDateTime)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The current time is within the selected reservation time. Please choose a different time.');
        }

        if ($startDateTime->greaterThan($oneWeekLater)) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'The reservation time must be within one week from now.');
        }

        $durationInMinutes = $startDateTime->diffInMinutes($endDateTime);
        if ($durationInMinutes < 60) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The reservation time must be at least 1 hour.');
        }

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $courtId = $request->input('court_id');
        $date = $request->input('date');
        $overlapExists = $this->reservationService->handleReservation($date, $startTime, $endTime, $courtId);

        if (!$overlapExists->isEmpty()) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'The selected time slot overlaps with an existing reservation.');
        }


        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $courtId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date,
        ]);

        Mail::to('tkprilep@gmail.com')->send(
            new NewReservation($reservation)
        );

        return redirect()->route('reservation.show')->with('success', 'Reservation made successfully!');
    }

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

    public function edit(Request $request, string $id)
    {
        $courtNumber = (int)$request->query('court_number');
        $date1 = Carbon::parse($request->query('date'))->format('Y-m-d');
        $startTime=Carbon::parse($request->query('start_time'))->format('H:i');
        $endTime=Carbon::parse($request->query('end_time'))->format('H:i');

        $user = Auth::user();
        $courts = Court::all();
        $reservation = Reservation::with('user', 'court')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');

        $datesForWeek = $this->reservationService->generateDatesForWeek($now);
        $date = $request->input('date', $today);
        $availableSlots = $this->reservationService->getAvailableSlots($date);
        $allSlotsReal = $availableSlots['allSlots'];

        return view('reservations.edit', compact('reservation', 'courts','date1','startTime', 'endTime', 'allSlotsReal', 'date', 'datesForWeek', 'courtNumber', 'date', 'datesForWeek', 'allSlotsReal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, Reservation $reservation)
    {
        $now = Carbon::now();
        $oneWeekLater = $now->copy()->addWeek();
        $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('start_time'));

        $endDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('end_time'));

        if ($startDateTime->isPast() || $endDateTime->isPast()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The reservation time must be in the future.');
        }

        if ($startDateTime->greaterThan($oneWeekLater)) {
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'The reservation time must be within one week from now.');
        }

        $durationInMinutes = $startDateTime->diffInMinutes($endDateTime);
        if ($durationInMinutes < 60) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The reservation time must be at least 1 hour.');
        }

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $courtId = $request->input('court_id');
        $date = $request->input('date');

        $overlapExists = $this->reservationService->handleReservation($date, $startTime, $endTime, $courtId);
        $overlapExists1 = $overlapExists->where('id', '!=', $reservation->id);

        if (!$overlapExists1->isEmpty()) {
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
