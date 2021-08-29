<?php

namespace App\Helper\User;

use App\Helper\BaseOption;
use Illuminate\Support\Facades\Hash;

class RegisterOption extends BaseOption
{
    /**
     * @param $request
     * @return array
     */
    public function optionArray($request): array
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
    }
}
