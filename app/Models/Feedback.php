<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional: Laravel assumes 'feedbacks' by default)
     */
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     * This allows us to use Feedback::create() in our web.php
     */
    protected $fillable = [
        'rating',
        'comments',
    ];
}