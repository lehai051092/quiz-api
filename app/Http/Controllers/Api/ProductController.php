<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SessionCustomer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getData(Request $request): JsonResponse
    {
        $token = $request->header('token');
        $tokenIsValid = SessionCustomer::where('token', $token)->first();
        $products = Product::all();

        if (empty($token) || empty($products)) {
            return response()->json([
                'code' => 401,
                'messages' => 'Something went wrong!!!'
            ], 401);
        } elseif (empty($tokenIsValid)) {
            return response()->json([
                'code' => 401,
                'messages' => 'Token invalid!!!'
            ], 401);
        }

        return response()->json([
            'code' => 200,
            'data' => $products
        ], 200);
    }
}
