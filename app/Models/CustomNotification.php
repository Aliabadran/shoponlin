<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Model
{
    use HasFactory;

    protected $table = 'custom_notifications';

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    // Cast data column to an array (for JSON data)
 //   protected $casts = [   'data' => 'array',   'is_read' => 'boolean',  ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
