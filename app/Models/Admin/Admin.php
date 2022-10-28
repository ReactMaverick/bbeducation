<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_user';

    protected $guard = 'admin';

    protected $fillable = [
        'user_name', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
