<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapoint extends Model
{
    use HasFactory;

    protected $table = 'datapoints';
}
