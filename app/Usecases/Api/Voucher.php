<?php

namespace App\Usecases\Api;

use App\Models\VoucherModel;
use App\Models\UserModel;

class Voucher
{
    protected $voucherModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->voucherModel = new VoucherModel();
        $this->userModel = new UserModel();
    }

    public function get_vouchers($payload)
    {
        $vouchers = $this->voucherModel->get_vouchers(
            $payload['limit'],
            $payload['page'],
            $payload['order_by']
        );

        return [
            "data" =>[
                    "vouchers" => $vouchers,
                ]
        ];
    }

    public function get_voucher_by_id($id)
    {
        $voucher = $this->voucherModel->get_by_id($id);

        if(empty($voucher)){
            return [
                "message" => "data not found",
            ];
        }

        return [
            "data" => $voucher,
        ];
    }
}