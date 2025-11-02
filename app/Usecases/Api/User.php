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

    public function get_user($id)
    {
        $user = $this->userModel->get($id);

        return [
            "data" =>$user
        ];
    }

    public function update_fcm_token($id, $payload)
    {
        $result = $this->userModel->update_fcm_token($id, $payload['fcm_token']);
        if(!$result){
            return [
                "success" => false,
                "message" => "error when update",
            ];
        }
        return [
            "success" => true,
        ]; 
    }
}