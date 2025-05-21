<?php

namespace App\Observers;

use App\Models\Subtask;
use App\Notifications\AllSubtasksCompleted;

class SubtaskObserver
{
    /**
     * Handle the Subtask "created" event.
     */
    public function created(Subtask $subtask): void
    {
        //
    }

    /**
     * Summary of updated
     * @param \App\Models\Subtask $subtask
     * @return void
     */
    public function updated(Subtask $subtask): void
    {
        $task = $subtask->task;
        $subtasks = $task->subtasks;

        if ($subtasks->isEmpty()) {
            $task->update(['status' => 'pending']);
            return;
        }

        $allCompleted = $subtasks->every(function ($subtask) {
            return $subtask->status === 'completed';
        });

        $anyInProgress = $subtasks->contains(function ($subtask) {
            return $subtask->status === 'in_progress';
        });

        if ($allCompleted) {
            $task->update(['status' => 'completed']);
            $task->user->notify(new AllSubtasksCompleted($task));
        } elseif ($anyInProgress) {
            $task->update(['status' => 'in_progress']);
        } else {
            $task->update(['status' => 'pending']);
        }
    }

    /**
     * Handle the Subtask "deleted" event.
     */
    public function deleted(Subtask $subtask): void
    {
        //
    }

    /**
     * Handle the Subtask "restored" event.
     */
    public function restored(Subtask $subtask): void
    {
        //
    }

    /**
     * Handle the Subtask "force deleted" event.
     */
    public function forceDeleted(Subtask $subtask): void
    {
        //
    }
}
