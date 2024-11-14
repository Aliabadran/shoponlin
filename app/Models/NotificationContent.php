<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationContent extends Model
{
    use HasFactory;
    protected $table = 'notifications_content';
    protected $fillable = ['title','message','url'];
   
}
