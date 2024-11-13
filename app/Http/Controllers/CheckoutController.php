<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CheckoutController extends Controller
{
    public function directcheckout(Request $request)
    {
        if(!Auth::check())
        {
            session(['url.intended' => route('checkout.direct')]);
            return redirect()->route("login");
        }else{
            return view('checkout');
        }
    }
}
