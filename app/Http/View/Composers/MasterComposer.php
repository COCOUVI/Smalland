<?php

namespace App\Http\View\Composers;

use App\Models\user_formation;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFormation;

class MasterComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $firstFormation = user_formation::where('user_id', Auth::id())
                ->orderBy('created_at', 'asc')
                ->first();

            $view->with('firstFormation', $firstFormation);
        }
    }
}
