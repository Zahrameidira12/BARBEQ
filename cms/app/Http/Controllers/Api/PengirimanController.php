<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

    class PengirimanController extends Controller
    {
        
       public function index()
{
    try {
        // Retrieve all records from the Pengiriman model
        $pengiriman = Pengiriman::all();

        // Return a simpler response for debugging
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $pengiriman->toArray()
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    }
