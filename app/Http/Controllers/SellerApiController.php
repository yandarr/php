<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Models\Seller;

class SellerApiController extends Controller
{

    /*
    public function __construct() {

        $this->middleware('auth:api');

    }
    */

    public function store(Request $request) {

        //Log::info(print_r($request->input(), true));

        $seller = Seller::create([
            'name' => $request->input('name'),
        ]);

        return response()->json($seller, 201);

    }

    public function index() {
        $seller = Seller::all();
        return response()->json($seller, 200);
    }

    public function getById($id) {
        $seller = Seller::where('id', $id)->first();
        if (empty($seller)) {
            return response()->json([ 'message' => 'Not found' ], 404);
        }
        return response()->json($seller, 200);
    }
    
}
