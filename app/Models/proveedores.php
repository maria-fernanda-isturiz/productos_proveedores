<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;

class proveedores extends Model
{
    use HasFactory, Authenticatable, HasApiTokens;
    protected $table = 'proveedores';
}
