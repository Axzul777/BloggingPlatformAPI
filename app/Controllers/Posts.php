<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
// use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PostsModel;


class Posts extends ResourceController
{
    // protected $modelName = 'App\Models\PostsModel';
    // protected $format = 'json';

    public function index()
    {
        $term = $this->request->getGet("term");

        $model = new PostsModel();

        if ($term) {
            $res = $model->like('tags', $term)->findAll();

            if (empty($res)) {
                return $this->failNotFound();
            }

            return $this->respond($res);
        }


        return $this->respond($model->findAll());
    }

    public function show($id = null) 
    {
        $model = new PostsModel();
        
        $post = $model->find($id);

        if (!$post) {
            return $this->failNotFound("User not found");
        }

        return $this->respond($post);
    }

    public function create() {
        $data = $this->request->getJSON(true);

        $model = new PostsModel();

        $model->insert($data);
    }

    public function delete($id = null) {
        $model = new PostsModel();

        if (!$id) {
            return $this->failNotFound("Id not found");
        }

        $model->delete($id);
    }
}

