<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralFeedback extends Model
{
    use HasFactory;
    protected $table = 'general_feedbacks';
    protected $fillable = ['title', 'description'];

    // Polymorphic relationship with comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
