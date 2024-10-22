<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;
    
    protected $table = ('candidat');

    protected $fillable = [
        'nom',
        'specialisation',
        'genre',
        'telephone',
        'adresse',
        'email',
        'id_poste',
        'nationalite' ,
        'date_postule' ,
        'date_insertion',
        'date_naissance',
        'formation_diplome',
        'competence',
        'experience_pro',
        'qualite',
        'centre_interet',
        'id_statu',
        'id_cv_path',
    ];
}