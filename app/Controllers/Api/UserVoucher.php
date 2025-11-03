<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Usecases\Api\UserVoucher as userVoucherUsecase;

class UserVoucher extends ResourceController
{
    protected $userVoucherUsecase;
    public function __construct()
    {
        $this->userVoucherUsecase = new userVoucherUsecase();
    }

    public function user_voucher()
    {
        $payload =$this->request->getGet();
        $payload['limit'] = empty($payload['limit']) ? 10 : (int)$payload['limit'];
        $payload['page'] = empty($payload['page']) ? 1 : (int)$payload['page'];
        $payload['order_by'] = empty($payload['order_by']) ? "id;desc" : $payload['order_by'];
        $payload['status'] = empty($payload['status']) ? 0 : (int)$payload['status'];

        $result = $this->userVoucherUsecase->vouchers_by_user_id(
            $this->request->user,
            $payload);

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

    public function insert_voucher()
    {
        // Ambil data input dari request
        $payload = $this->request->getJSON(true);
        $rules = [
            'voucher_id'  => [
                "rules" => 'required',
                'errors' => [
                    'required'    => 'voucher_id wajid diisi',
                ],
            ],
        ];        

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => strtolower(reset($errors)),
            ])->setStatusCode(400);
        }
        $result = $this->userVoucherUsecase->insert_voucher(
            $this->request->user, 
            $payload
        );

        if (isset($result['message'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $result['message'],
            ])->setStatusCode(422 );
        }
        
        return $this->respond([
            'status' => 'success',
        ]);
    }
}