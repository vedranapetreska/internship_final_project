<?php

namespace App\Repositories;

use App\Models\Reservation;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ReservationRepository.
 */
class ReservationRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Reservation::class;
    }
}
