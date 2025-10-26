<?php

namespace App\Http\View\Composers;

use App\Models\Cart;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $cartCount = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cartCount = $cart ? $cart->totalItems() : 0;
        }

        $view->with('cartCount', $cartCount);
    }
}