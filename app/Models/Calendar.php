<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Calendar extends Model
{
    use SoftDeletes;

    protected $table = 'calendar';

    protected $guarded = ['id'];

    protected $fillable = 
    [
        'event_name',
        'event_date',
        'created_by',
        'updated_by',
    ];
}
