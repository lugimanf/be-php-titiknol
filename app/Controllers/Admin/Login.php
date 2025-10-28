<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
// use App\Usecases\Api\Auth as AuthUsecase;
// use App\Models\UserModel;

class Login extends Controller
{
    // protected $authUsecase;
     
    public function __construct()
    {
        // $this->authUsecase = new AuthUsecase();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            // Ambil data input dari request
            $payload = $this->request->getJSON(true);

            $rules = [
                'email'    => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required'    => 'Email wajib diisi.',
                        'valid_email' => 'Format email tidak valid.',
                    ],
                ],
            ];
        }
        return view('Admin/login');
    }

    public function otp()
    {
        if ($this->request->getMethod() === 'post') {
            // Ambil data input dari request
            $payload = $this->request->getJSON(true);

            $rules = [
                'email'    => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required'    => 'Email wajib diisi.',
                        'valid_email' => 'Format email tidak valid.',
                    ],
                ],
            ];
        }
        return view('Admin/login');
    }
}