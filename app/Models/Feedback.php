<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'Feedbacks';
    protected $fillable = ['user_id', 'title', 'body', 'category', 'is_public', 'status', 'parent_id'];
    

    // Relationship to the user who submitted the feedback
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship for replies (self-referencing)
    public function replies()
    {
        return $this->hasMany(Feedback::class, 'parent_id');
    }

    // Parent feedback reference
    public function parent()
    {
        return $this->belongsTo(Feedback::class, 'parent_id');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
