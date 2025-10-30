<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Usecases\Api\Voucher as voucherUsecase;
use Illuminate\Http\Request;

class Voucher extends ResourceController
{
    protected $voucherUsecase;
    public function __construct()
    {
        $this->voucherUsecase = new voucherUsecase();
    }
    public function index()
    {
        $payload =$this->request->getGet();
        $payload['limit'] = empty($payload['limit']) ? 10 : (int)$payload['limit'];
        $payload['page'] = empty($payload['page']) ? 1 : (int)$payload['page'];
        $payload['order_by'] = empty($payload['order_by']) ? "id;desc" : (int)$payload['page'];

        $result = $this->voucherUsecase->get_vouchers($payload);

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

    public function get_by_id($id)
    {
        $result = $this->voucherUsecase->get_voucher_by_id($id);

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