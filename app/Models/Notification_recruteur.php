<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification_recruteur extends Model
{
    use HasFactory;

    protected $table = 'notification_recruteur';

    protected $fillable = [
        'id_recruteur',
        'id_notification',
        'is_read',
        'is_deleted',
    ];
}