<?php

namespace App\Services;

use Carbon\Carbon;

class TimeSlotService
{

    public function generateTimeSlots($startTime, $endTime, $intervalMinutes = 30)
    {
        $slots = [];
        $current = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        while ($current->lessThan($end)) {
            $slots[] = [
                'start' => $current->format('H:i'),
                'end' => $current->copy()->addMinutes($intervalMinutes)->format('H:i'),
                'reserved'=>false
            ];
            $current->addMinutes($intervalMinutes);
        }

        return $slots;
    }

    public function isOverlapping($slot, $reserved)
    {
        $slotStart = Carbon::parse($slot['start']);
        $slotEnd = Carbon::parse($slot['end']);
        $reservedStart = Carbon::parse($reserved->start_time);
        $reservedEnd = Carbon::parse($reserved->end_time);
//        dd($reservedEnd,$reservedStart, $slotStart, $slotEnd);

        return $slotStart < $reservedEnd && $slotEnd > $reservedStart;
    }
}
