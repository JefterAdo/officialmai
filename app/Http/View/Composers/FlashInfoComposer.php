<?php

namespace App\Http\View\Composers;

use App\Models\FlashInfo;
use Illuminate\View\View;

class FlashInfoComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $flashInfos = FlashInfo::active()->get();
        $view->with('flashInfos', $flashInfos);
    }
}
