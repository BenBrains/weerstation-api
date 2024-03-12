<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;
    protected $table = 'sensors';

    public function datapoints() {
        return $this->hasMany(DataPoint::class);
    }
}
