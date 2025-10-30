<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Entity\Entity;

class Article extends Entity
{
    protected $casts = [
        'id'       => 'integer',
        'article_category_id' => 'integer',
        'title'    => 'string',
        'content'    => 'string',
        'image'    => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

class ArticleModel extends Model
{
    protected $table = 'articles'; // Nama tabel
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'content'];
    protected $returnType = Article::class;
    protected $useTimestamps = true;

    // Fungsi untuk mencari user berdasarkan username
    public function get($limit, $page, $order_by)
    {
        $data = $this->limit($limit, ($page - 1) * 10);
        if(!empty($order_by)){
            $order_by_split = explode(";", $order_by);
            $type_order = empty($order_by_split[1]) ? "asc" : $order_by_split[1];
            $data = $data->orderBy($order_by_split[0], $type_order);
        }
        return $data->select("title, id, image")
            ->where("is_publish", 1)
            ->find();
        
    }
}