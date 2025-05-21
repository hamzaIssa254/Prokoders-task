<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtask extends Model
{
    use HasFactory;
protected $fillable = ['task_id', 'title', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
