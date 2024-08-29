<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmation;
use App\Mail\ReservationDenied;
use App\Models\Reservation;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{

    protected $reservationService;
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index(Request $request)
    {
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $date = $request->input('date');
        $status = $request->input('status');
        $datesForWeek = $this->reservationService->generateDatesForWeek($now);

        $reservationsQuery = Reservation::with('user', 'court');

        if ($date) {
            $reservationsQuery->where('date', $date)
                ->orderBy('start_time');
        }

        if ($status) {
            $reservationsQuery->where('status', $status)
                ->orderBy('date');
        }

        $reservations = $reservationsQuery->paginate(10);

        return view('admin.index', compact('reservations', 'datesForWeek', 'date'));
    }



    public function approveReservation($id)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->status = 'approved';
            $reservation->save();

            Mail::to($reservation->user->email)->send(
                new ReservationConfirmation($reservation)
            );
        }

        return redirect()->route('admin.index');
    }

    public function denyReservation($id)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->status = 'denied';
            $reservation->save();

            Mail::to($reservation->user->email)->send(
                new ReservationDenied($reservation)
            );
        }

        return redirect()->route('admin.index');
    }
    public function deleteReservation($id){
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('admin.index');
    }
}
