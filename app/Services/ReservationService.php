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

    public function getAvailableSlots($date){

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
                'slots' => $freeSlots,

            ];
        }

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
        return [
            'allSlots' => $allSlotsReal,
            'freeSlots' => $freeSlotsByCourt,
        ];
    }

    public function handleReservation($date, $startTime, $endTime, $courtId){

        $overlapExists = Reservation::where('court_id', $courtId)
            ->where('date', $date)
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
