<?php

namespace App\Usecases\Api;

use App\Models\VoucherModel;
use Config\Services;

class Voucher
{
    protected $voucherModel;
    protected $session;

    public function __construct()
    {
        $this->voucherModel = new VoucherModel();
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
}