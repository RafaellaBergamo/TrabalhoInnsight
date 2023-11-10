<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroHospede extends Model
{
    use HasFactory;

    protected $fillable = [
        'idReserva',
        'idHospede',
        'dtCheckin',
        'dtCheckout'
    ];
}
