<?php

namespace App\Observers;

use App\Models\UserAction;
use Illuminate\Support\Facades\Auth;

class UserActionsObserver
{
    public function saved($model)
    {
        if ($model->wasRecentlyCreated == true) {
            $action = 'created';
        } else {
            $action = 'updated';
        }
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => $action,
                'action_model' => $model->getTable(),
                'action_id'    => $model->id
            ]);
        }
    }

    public function deleting($model)
    {
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => 'deleted',
                'action_model' => $model->getTable(),
                'action_id'    => $model->id
            ]);
        }
    }
}
