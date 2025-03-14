<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'description',
        'date',
        'sender_id',
        'receiver_id',
        'status'
    ];
}
