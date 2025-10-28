<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Usecases\Api\Article as ArticleUsecase;

class Article extends ResourceController
{
    protected $articlesUsecase;
    public function __construct()
    {
        $this->articlesUsecase = new ArticleUsecase();
    }
    public function index()
    {
        // Ambil data input dari request
        $payload =$this->request->getGet();
        $payload['limit'] = empty($payload['limit']) ? 10 : (int)$payload['limit'];
        $payload['page'] = empty($payload['page']) ? 1 : (int)$payload['page'];
        $payload['order_by'] = empty($payload['order_by']) ? "id;desc" : (int)$payload['page'];
        
        $result = $this->articlesUsecase->get_article($payload);

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