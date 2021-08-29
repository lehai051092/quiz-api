<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCustomer extends Model
{
    use HasFactory;

    protected $table = 'session_customers';
    protected $fillable = ['token', 'refresh_token', 'token_expire', 'refresh_token_expire', 'customer_id'];
}
