<?php

namespace App\Usecases\Api;

use App\Models\ArticleModel;
use Config\Services;

class Article
{
    protected $articleModel;
    protected $session;

    public function __construct()
    {
        $this->articleModel = new ArticleModel();
        $this->session = Services::cache();
    }

    public function get_article($payload)
    {
        $articles = $this->articleModel->get($payload['limit'],$payload['page'],$payload['order_by']);
        return [
            "data" => [
                    "articles" => $articles,
                ]
        ];

            

    }
}