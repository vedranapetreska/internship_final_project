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
        $reservation = Reservation::findOrFail($id);
        if ($reservation) {
            $reservation->status = 'approved';
            $reservation->save();

            Mail::to($reservation->user->email)->send(
                new ReservationConfirmation($reservation)
            );
        }

        return redirect()->back();
    }

    public function denyReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation) {
            $reservation->status = 'denied';
            $reservation->save();

            Mail::to($reservation->user->email)->send(
                new ReservationDenied($reservation)
            );
        }

        return redirect()->back();
    }
    public function softDeleteReservation($id){
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->back();
    }

    public function showDeletedReservations()
    {
        $deletedReservations = Reservation::onlyTrashed()->paginate(10);

        return view('admin.deleted-reservations', compact('deletedReservations'));
    }

    public function restoreReservation($id)
    {
        $reservation = Reservation::withTrashed()->findOrFail($id);
        $reservation->restore();
        return redirect()->back()->with('success', 'Reservation restored successfully.');
    }

}
