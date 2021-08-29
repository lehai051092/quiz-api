<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SessionCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $customers = Customer::all();

        if (empty($customers)) {
            return response()->json([
                'code' => 400,
                'messages' => 'Something went wrong!!!'
            ], 400);
        };

        foreach ($customers as $customer) {
            if ($customer->email === $data['email'] && Hash::check($data['password'], $customer->password)) {
                $checkTokenExist = SessionCustomer::where('customer_id', $customer->id)->first();
                if (empty($checkTokenExist)) {
                    $customerSession = SessionCustomer::create([
                        'token' => Str::random(40),
                        'refresh_token' => Str::random(40),
                        'token_expire' => date('Y-m-d H:i:s', strtotime('+30 day')),
                        'refresh_token_expire' => date('Y-m-d H:i:s', strtotime('+360 day')),
                        'customer_id' => $customer->id
                    ]);
                } else {
                    $customerSession = $checkTokenExist;
                }

                return response()->json([
                    'code' => 200,
                    'data' => $customerSession,
                    'message' => 'Logged in successfully %1!!!', $customer->name
                ], 200);
            }
        }

        return response()->json([
            'code' => 401,
            'messages' => 'Username or password wrong!!!'
        ], 401);
    }
}
