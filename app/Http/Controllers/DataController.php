<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{

    function getCategories(Request $request)
    {
        $text2Search = $request->get('q');

        $results = Category::where('name', 'like', "%{$text2Search}%")->orderBy('name', 'asc')
            ->get()->take(10);

        return response()->json($results);
    }

    function getCustomers(Request $request)
    {

        $text2Search = $request->get('q');

        $results = Customer::where('first_name', 'like', "%{$text2Search}%")
            ->orWhere('last_name', 'like', "%{$text2Search}%")
            ->orWhere('email', 'like', "%{$text2Search}%")
            ->select('id', 'first_name', 'last_name', 'email', DB::raw(" concat(first_name , ' ' , last_name)as text "))
            ->orderBy('first_name', 'asc')
            ->get()->take(10);


        return response()->json($results);
    }
}
