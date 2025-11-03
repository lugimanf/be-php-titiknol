<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity\Entity;

class UserVoucher extends Entity
{
    protected $casts = [
        'id'                    => 'integer',
        'voucher_id'            => 'integer',
        'user_id'               => 'integer',
        'code'                  => 'string',
        'price'                 => 'float',
        'status'                => 'integer',
        'detail'                => 'string',
        'image'                 => 'string',
        'name'                  => 'string',
        'description'           => 'string',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
    ];
}

class UserVoucherModel extends Model
{
    protected $table = 'user_voucher'; // Nama tabel
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'voucher_id', 
        'user_id', 
        'code',
        'price',
        'status',
        'detail',
    ];
    protected $returnType = UserVoucher::class;
    protected $useTimestamps = true;

    public function vouchers_by_user_id($user_id, $payload)
    {
        $vouchers = $this->limit($payload["limit"], ($payload['page'] - 1) * $payload["limit"]);
        if(!empty($payload["order_by"])){
            $order_by_split = explode(";", $payload["order_by"]);
            $type_order = empty($order_by_split[1]) ? "asc" : $order_by_split[1];
            $vouchers = $vouchers->orderBy($order_by_split[0], $type_order);
        }
        $vouchers = $vouchers->select("user_voucher.id as id, code, status, user_voucher.created_at
        , vouchers.image as image, vouchers.name as name, vouchers.description as description")
        ->join("vouchers", "vouchers.id = user_voucher.voucher_id")
        ->where("status", $payload['status'])
        ->where("user_id", $user_id);
        return $vouchers->find();
    }

    public function user_voucher_by_id($id)
    {
        $user_voucher = $this->where("id", $id)->first();

        return $user_voucher;
    }

    //insert user voucher
    public function insert_voucher($data)
    {
        $voucher = $this->insert($data);            
        return $voucher;
    }
}