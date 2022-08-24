<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'location',
        'start_date',
        'end_date',
    ];
    
    /**
     * Eloquent relationship - One experience belongs to one user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
