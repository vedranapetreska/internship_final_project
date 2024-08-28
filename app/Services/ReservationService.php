<?php

namespace App\Services;

use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use http\Env\Request;

class ReservationService
{
    protected $timeSlotService;
    public function __construct(TimeSlotService $timeSlotService){
        $this->timeSlotService = $timeSlotService;
    }

    public function getAvailableSlots($date)
    {
        $startTime = '07:00';
        $endTime = '23:00';
        $allSlots = $this->timeSlotService->generateTimeSlots($startTime, $endTime);
        $reservedTimes = Reservation::where('date', $date)
            ->whereIn('status', ['approved', 'pending'])
            ->get(['court_id', 'start_time', 'end_time', 'status']);

        $freeSlotsByCourt = [];

        $courts = Court::all();
        foreach ($courts as $court) {
            $courtReservedTimes = $reservedTimes->where('court_id', $court->id);

            foreach ($allSlots as &$slot) {
                $slot['status'] = 'free';
                foreach ($courtReservedTimes as $reserved) {
                    if ($this->timeSlotService->isOverlapping($slot, $reserved)) {
                        if ($reserved->status == 'pending') {
                            $slot['status'] = 'pending';
                        } elseif ($reserved->status == 'approved') {
                            $slot['status'] = 'approved';
                        }
                        break;
                    }
                }
            }

            $freeSlotsByCourt[$court->id] = [
                'court_number' => $court->court_number,
                'slots' => $allSlots,
            ];
        }

        return [
            'allSlots' => $freeSlotsByCourt,
        ];
    }


    public function handleReservation($date, $startTime, $endTime, $courtId){

        $overlapExists = Reservation::where('court_id', $courtId)
            ->where('date', $date)->where('status', ['approved', 'pending'])
            ->where(function ($query) use ($startTime, $endTime) {
                // Check if the reservation overlaps with the start time
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                })->orWhere(function ($query) use ($startTime, $endTime) {
                    // Check if the new reservation fully encompasses an existing reservation
                    $query->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                });
            })
            ->get();

        return $overlapExists;

    }
    public function generateDatesForWeek(Carbon $now){
        $datesForWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $datesForWeek[] = $now->copy()->addDays($i)->format('Y-m-d');
        }

        return $datesForWeek;
    }
}
