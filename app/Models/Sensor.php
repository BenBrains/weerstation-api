<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'sensors';
    protected $fillable = [
        'station_id',
        'name',
        'type',
        'unit',
        'depth'
    ];

    public function datapoints() {
        return $this->hasMany(DataPoint::class);
    }
}
