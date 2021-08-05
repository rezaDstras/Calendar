<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'details',
        'start',
        'end',
        'color',
        'user_id',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
