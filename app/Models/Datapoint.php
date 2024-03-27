<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapoint extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'datapoints';

    protected $fillable = [
        'sensor_id',
        'value',
        'timestamp'
    ];
}
