<?php

namespace App\Controllers;

class Products extends BaseController
{
  public function __construct()
  {
    $this->model = model('ProductModel');
  }

  public function index()
  {
    return view('products/index');
  }

  public function getProducts()
  {
    if ($this->request->isAJAX()) {

      $page = $this->request->getVar('page') ?? 1;
      $query = $this->request->getVar('q');

      $perPage = 10;

      $offset = ($page - 1) * $perPage;

      try {
        $items = $this->model->getAllPagination($perPage, $offset, $query);
      
        $total = $this->model->countAll($query);
        
        $data = [
          'products' => $items,
          'pager' => \Config\Services::pager(),
          'total' => $total,
          'perPage' => $perPage,
        ];
  
        $content = view('products/content', $data);
  
        $output = [
          'status' => TRUE,
          'content' => $content
        ];

        echo json_encode($output);
      } catch (\Throwable $th) {
        $output = [
          'status' => FALSE,
          'message' => "{$th->getMessage()}"
        ];
  
        echo json_encode($output);
      }
    }
  }

  public function createProduct()
  {
    $rules = [
      'title' => 'required',
      'price' => ['required', 'numeric'],
    ];

    if (!$this->validate($rules)) {
      $errors = [
        'title' => $this->validation->getError('title'),
        'price' => $this->validation->getError('price'),
      ];

      $output = [
        'status' => FALSE,
        'errors' => $errors
      ];

      echo json_encode($output);
    } else {
      $item = [
        'title' => $this->request->getPost('title'),
        'price' => $this->request->getPost('price'),
      ];

      try {
        $createdItem = $this->model->create($item);

        echo json_encode(['status' => TRUE, 'product' => $createdItem]);
      } catch (\Throwable $th) {
        $output = [
          'status' => FALSE,
          'errors' => "{$th->getMessage()}"
        ];
  
        echo json_encode($output);
      }
    }
  }

  public function deleteProduct()
  {
    $rules = [
      'id' => 'required',
    ];

    if (!$this->validate($rules)) {
      $errors = [
        'id' => $this->validation->getError('id'),
      ];

      $output = [
        'status' => FALSE,
        'errors' => $errors
      ];

      echo json_encode($output);
    } else {
      $id = $this->request->getPost()['id'];

      try {
        $this->model->remove($id);

        echo json_encode(['status' => TRUE]);
      } catch (\Throwable $th) {
        echo json_encode(['status' => FALSE, 'errors' => $th->getMessage()]);
      }
    }
  }

  public function updateProduct()
  {
    $rules = [
      'id' => 'required',
      'title' => 'required',
      'created_at' => 'required',
      'price' => ['required', 'numeric'],
    ];

    if (!$this->validate($rules)) {
      $errors = [
        'title' => $this->validation->getError('title'),
        'id' => $this->validation->getError('id'),
        'price' => $this->validation->getError('price'),
        'created_at' => $this->validation->getError('created_at'),
      ];

      $output = [
        'status' => FALSE,
        'errors' => $errors
      ];

      echo json_encode($output);
    } else {
      $item = [
        'id' => $this->request->getRawInput()['id'],
        'title' => $this->request->getRawInput()['title'],
        'price' => $this->request->getRawInput()['price'],
        'created_at' => $this->request->getRawInput()['created_at'],
      ];

      try {
        $this->model->modify($item);

        echo json_encode(['status' => TRUE]);
      } catch (\Throwable $th) {
        echo json_encode(['status' => FALSE, 'errors' => $th->getMessage()]);
      }
    }
  }
}
