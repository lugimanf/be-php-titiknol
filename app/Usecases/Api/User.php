<?php

namespace App\Usecases\Api;

use App\Models\UserModel;
use Config\Services;

class User
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = Services::cache();
    }

    public function get_user($data)
    {
        $user = $this->userModel->get($data['user_id']);

        return [
            "data" =>$user
        ];
    }
}