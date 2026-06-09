<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'mst_users';
    protected $primaryKey = 'mus_id_users';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'mus_id_users',
        'mus_name',
        'mus_email',
        'mus_password',
        'mus_foto_profile',
        'mus_role',
        'mus_createBy',
        'mus_createDate',
    ];

    protected $hidden = [
        'mus_password',
    ];

    public function getAuthIdentifierName()
    {
        return 'mus_id_users';
    }

    public function getAuthPassword()
    {
        return $this->mus_password;
    }
}