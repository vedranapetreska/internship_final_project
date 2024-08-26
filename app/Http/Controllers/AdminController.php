<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;


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
        $date = $request->input('date',$today);
        $status=$request->input('status');
        $datesForWeek = $this->reservationService->generateDatesForWeek($now);

        $reservations = Reservation::with('user', 'court')
            ->where('date',$date)
            ->get();

        if($status){
            $reservations = $reservations->where('status',$status);
        }

        return view('admin.index', compact('reservations', 'datesForWeek', 'date'));
    }

    public function approveReservation($id){
        $reservation = Reservation::find($id);
        $reservation->status = 'approved';
        $reservation->save();
        return redirect()->route('admin.index')->with('success', 'Reservation approved');
    }

    public function denyReservation($id){
        $reservation = Reservation::find($id);
        $reservation->status = 'denied';
        $reservation->save();

        return redirect()->route('admin.index')->with('success', 'Reservation approved');
    }
}
