<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomersController extends Controller
{
    public function index(){
        $customers = User::role('customer')->get();
        foreach($customers as $u){
            $u->detail = $u->detail;
        }

        return response()->json(['customers' => $customers]);
    }
}
