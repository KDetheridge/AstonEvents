<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'Event';
    protected $fillable = ['EventTitle','EventDescription','EventCategory','EventStartTime','EventEndTime','EventLocation','EventOrganiserID','EventImageDir'];

    public $timestamps = false;

}