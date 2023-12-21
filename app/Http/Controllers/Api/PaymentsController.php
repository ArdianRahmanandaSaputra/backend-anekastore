<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PaymentsController extends Controller
{
    public function index(){
        $customers = User::role('customer')->get();
        foreach($customers as $u){
            $u->payment = $u->orders;
        }

        return response()->json(['customers' => $customers]);
    }
}
