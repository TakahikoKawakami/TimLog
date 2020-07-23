<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'parent_id',
        'text',
        'memo',
        'start_date',
        'stop_date',
        'deadline_date',
        'deadline_second',
        'display_sequence',
        'status',
    ];
}
