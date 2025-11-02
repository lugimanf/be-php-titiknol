<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $casts = [
        'id'            => 'integer',
        'first_name'    => 'string',
        'last_name'     => 'string',
        'email'         => 'string',
        'point'         => 'integer',
        'fcm_token'     => 'string',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];
}

class UserModel extends Model
{
    protected $table = 'users'; // Nama tabel
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password_hash', 'fcm_token', "point"];
    protected $returnType = User::class;
    protected $useTimestamps = true;

    // Fungsi untuk mencari user berdasarkan username
    public function get($id)
    {
        return $this->where('id', $id)->first();
    }

    public function find_by_email($email)
    {
        return $this->where('email', $email)->first();
    }

    public function update_fcm_token($id, $fcm_token)
    {
        return $this->update($id, ["fcm_token" => $fcm_token]);
    }

    public function update_point($id, $point)
    {
        return $this->update($id, ["point" => $point]);
    }
}