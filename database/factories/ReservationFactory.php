<?php

namespace Database\Factories;

use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $date = '2024-08-09';
            $startTime = fake()->time('H:00', '21:00');
            //convert startTime to a datetime object for easier adding intervals
            $startDateTime = \DateTime::createFromFormat('Y-m-d H:i', "$date $startTime");
            $intervalOptions = [60,90,120];
            $randomInterval = fake()->randomElement($intervalOptions);
            $endDateTime = (clone $startDateTime);
            $endDateTime->modify('+' . $randomInterval . 'minutes');
            $endTime = $endDateTime->format('H:00');



        return [
            'court_id' =>  Court::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date
        ];

    }
}
