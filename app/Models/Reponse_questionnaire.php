<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse_questionnaire extends Model
{
    use HasFactory;
    protected $table = 'reponse_questionnaire';

    protected $fillable = [
        'id_question',
        'reponse',
        'note',
        
    ];
}
