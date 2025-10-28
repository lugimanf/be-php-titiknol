<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Usecases\Api\User as userUsecase;
use Illuminate\Http\Request;

class User extends ResourceController
{
    protected $userUsecase;
    public function __construct()
    {
        $this->userUsecase = new userUsecase();
    }
    public function index()
    {
        // Ambil data input dari request
        $payload = [
            "user_id" => $this->request->user['id'],
        ];
        
        $result = $this->userUsecase->get_user($payload);

        if (isset($result['message'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $result['message'],
            ])->setStatusCode(404);
        }
        
        return $this->respond([
            'status' => 'success',
            'data' => $result['data'],
        ]);
    }
}