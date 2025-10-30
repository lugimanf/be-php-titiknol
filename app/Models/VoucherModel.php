<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity\Entity;

class Voucher extends Entity
{
    protected $casts = [
        'id'                    => 'integer',
        'voucher_type_id'       => 'integer',
        'name'                  => 'string',
        'description'           => 'string',
        'discount_in_percent'   => 'float',
        'price'                 => 'float',
        'images'                => 'string',
        'discount_price'        => 'float',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
    ];
}

class VoucherModel extends Model
{
    protected $table = 'vouchers'; // Nama tabel
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 
        'description', 
        'discount_in_percent',
        'price',
        'image',
    ];
    protected $returnType = Voucher::class;
    protected $useTimestamps = true;

    // Fungsi untuk mendapatkan list voucher yang aktif
    public function get_vouchers($limit, $page, $order_by)
    {
        $vouchers = $this->limit($limit, ($page - 1) * 10);
        if(!empty($order_by)){
            $order_by_split = explode(";", $order_by);
            $type_order = empty($order_by_split[1]) ? "asc" : $order_by_split[1];
            $data = $vouchers->orderBy($order_by_split[0], $type_order);
        }
        $vouchers = $data->select("id, name, image, price, discount_in_percent, CEIL(price * (100 - discount_in_percent) / 100) as discount_price")
        ->where("is_active", 1);
        return $vouchers->find();
    }

    public function get_by_id($id)
    {
        $voucher = $this->select("*, CEIL(price * (100 - discount_in_percent) / 100) as discount_price", )
            ->where("id",$id)
            ->where("is_active",1)
            ->first();
        return $voucher;
    }
}