<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'incident_date',
        'location',
        'image_path',
        'status',
    ];

    protected $casts = [
        'incident_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}