<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Log extends BaseController
{
    public function __construct()
    {
        $this->model = model('LogModel');
    }

    public function index()
    {
        return view('admin/logs/index');
    }

    public function getLogs()
    {
      if ($this->request->isAJAX()) {
  
        $page = $this->request->getVar('page') ?? 1;
  
        $perPage = 10;
  
        $offset = ($page - 1) * $perPage;
        
        $items = $this->model->getAllPagination($perPage, $offset);
        
        $total = $this->model->countAll();
        
        $data = [
          'logs' => $items,
          'pager' => \Config\Services::pager(),
          'total' => $total,
          'perPage' => $perPage,
        ];
  
        $content = view('admin/logs/content', $data);
  
        $output = [
          'status' => TRUE,
          'content' => $content
        ];

        echo json_encode($output);
      }
    }
}
