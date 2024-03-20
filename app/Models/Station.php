<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'stations';

    protected $fillable = [
        'name',
        'location',
        'hardware_version',
        'software_version',
        'lat',
        'lon'
    ];
}
