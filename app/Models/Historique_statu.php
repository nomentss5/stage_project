<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique_statu extends Model
{
    use HasFactory;

    protected $table = ('historique_statut');

    protected $fillable = [
        'id',
        'id_user',
        'id_candidat',
        'id_statu_avant',
        'id_statu_apres',
        'created_at',
        'updated_at',
    ];

}