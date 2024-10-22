<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionMessage extends Model
{
    use HasFactory;

    protected $table= 'suggestion_message';

    protected $fillable = [
        'nom',
        'message'
    ];

}