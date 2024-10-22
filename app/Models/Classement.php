<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classement extends Model
{
    use HasFactory;

    protected $table =('classement');

    protected $fillable = [
        'id_user',
        'id_poste',
        'point',
    ];

}
