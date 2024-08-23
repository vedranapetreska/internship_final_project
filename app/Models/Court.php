<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Court extends Model
{

    protected $fillable = ['court_number'];
    use HasFactory;

//    public function Reservation(){
//        return $this->hasMany(Reservation::class);
//    }
}


