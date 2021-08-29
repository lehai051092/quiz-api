<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['name', 'email', 'password', 'age', 'date_of_birth', 'address', 'phone', 'avatar', 'role_id'];
    protected $hidden = ['password'];
}
