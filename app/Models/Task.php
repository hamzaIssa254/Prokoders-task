<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
use HasFactory;
protected $fillable = ['user_id', 'title', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function scopeTitle(Builder $query, $title)
    {
        return $query->where('title',$title);
    }

    public function scopeStatus(Builder $query,$status)
    {
        return $query->where('status',$status);
    }

     public function scopeUserID(Builder $query,$userID)
    {
        return $query->where('user_id',$userID);
    }


}
