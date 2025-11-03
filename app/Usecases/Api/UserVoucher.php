<?php

namespace App\Usecases\Api;

use App\Models\UserVoucherModel;
use App\Models\VoucherModel;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class UserVoucher
{
    protected $userVoucherModel;
    
    protected $voucherModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->voucherModel = new VoucherModel();
        $this->userVoucherModel = new UserVoucherModel();
        $this->userModel = new UserModel();
    }

    public function vouchers_by_user_id($user, $payload)
    {
        $user_vouchers = $this->userVoucherModel->vouchers_by_user_id($user->id, $payload);

        return [
            "data" => ["user_vouchers" => $user_vouchers],
        ];
    }

    public function insert_voucher($user, $payload)
    {
        $voucher = $this->voucherModel->get_by_id($payload['voucher_id']);
        if(empty($voucher)){
            return [
                "error_code" => "403",
                "message" => "voucher tidak ditemukan",
            ];
        }

        if ($user->point < $voucher->final_price) {
            return [
                "error_code" => "403",
                "message" => "poin tidak cukup",
            ];
        }

        $data = [
            "user_id" => $user->id,
            "voucher_id" => $payload['voucher_id'],
            "code" => Uuid::uuid4()->toString(),
            "price" => $voucher->final_price,
            "detail" => json_encode([
                "discount_in_percent" => $voucher->discount_in_percent,
                "price" => $voucher->price,
                "final_price" => $voucher->final_price,
            ])
        ];
        $this->userVoucherModel->insert_voucher($data);

        $current_point = $user->point - $voucher->final_price;
        $this->userModel->update_point($user->id, $current_point);

        return [
            "data" => $voucher,
        ];
    }
}