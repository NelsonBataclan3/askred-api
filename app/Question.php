<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question', 'answer', 'asked_by', 'hash', 'answered_by'
    ];
}
