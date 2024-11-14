<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id', 'parent_id', 'commentable_type', 'commentable_id'];

    // Polymorphic relationship to other models (e.g., Product, Feedback)
    public function commentable()
    {
        return $this->morphTo();
    }

    // Relationship to the user who made the comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Self-referencing relationship for replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Self-referencing relationship for the parent comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }


}
