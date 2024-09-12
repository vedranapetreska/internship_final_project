<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'court_id', 'date', 'start_time', 'end_time', 'status',
    ];

    public function Court(){
        return $this->belongsTo(Court::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
