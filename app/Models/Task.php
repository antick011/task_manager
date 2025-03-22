<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'status', 'priority', 'progress', 'deadline', 'assigned_email'
    ];
    
    // Relationship: Task belongs to a user (creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Task is assigned to a user
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_email', 'email');
    }



    // Relationship: Task has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
