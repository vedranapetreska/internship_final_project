<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all reservations with related user and court data
        $reservations = Reservation::with(['user', 'court'])->get();

        // Pass the reservations to the view
        return view('reservations.index', compact('reservations'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courts = Court::all(); // Retrieve all courts from the database
        return view('reservations.create', compact('courts'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'start_time' => 'required|date_format:H:i', // Validate as a required time in the format HH:MM
            'end_time' => 'required|date_format:H:i|after:start_time', // Validate as a required time in the format HH:MM and must be after start_time
            'date' => 'required|date_format:Y-m-d',
        ]);


        // Extract the input values from the request
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $courtId = $request->input('court_id');
        $date = $request->input('date');

        // Check if the new reservation overlaps with existing reservations
        $overlapExists = Reservation::where('court_id', $courtId)
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

        // If an overlap is detected, return an error response
        if ($overlapExists) {
            return redirect()->back()->with('error', 'The selected time slot overlaps with an existing reservation.');
        }

        // If no overlap, create a new reservation
        Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $courtId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Reservation made successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
