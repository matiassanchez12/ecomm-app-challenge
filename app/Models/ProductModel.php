<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ProductModel extends Model
{
    private $filePath;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $this->logModel = model('LogModel');

        $this->filePath = APPPATH . '/Database/products.json';
    }

    public function getAll()
    {
        $fileExist = file_exists($this->filePath);

        if (!$fileExist) {
            throw new Exception("File not found", 1);
        }

        $data = file_get_contents($this->filePath);

        return json_decode($data, true);
    }

    public function getAllPagination($limit, $offset, $query)
    {
        $items = $this->getAll();

        $this->logModel->createLog('Ver listado de productos');

        if ($query) {
            $filtered = array_filter($items, function ($item) use ($query) {
                $query = strtolower($query);

                $titleMatch = stripos(strtolower($item['title']), $query) !== false;
                $dateMatch = stripos(strtolower($item['created_at']), $query) !== false;
                $priceMatch = stripos(strtolower((string)$item['price']), $query) !== false;

                return $titleMatch || $dateMatch || $priceMatch;
            });

            return array_slice($filtered, $offset, $limit);
        }

        return array_slice($items, $offset, $limit);
    }

    public function getById($id)
    {
        $query = $this->db->get_where('usuarios', array('id' => $id));
        return $query->row();
    }


    public function countAll($query)
    {
        $items = $this->getAll();

        if ($query) {
            $items = array_filter($items, function ($item) use ($query) {
                $query = strtolower($query);

                $titleMatch = stripos(strtolower($item['title']), $query) !== false;
                $dateMatch = stripos(strtolower($item['created_at']), $query) !== false;
                $priceMatch = stripos(strtolower((string)$item['price']), $query) !== false;

                return $titleMatch || $dateMatch || $priceMatch;
            });
        }

        return count($items);
    }

    public function create($data)
    {
        $items = $this->getAll();

        $lastId = $items[count($items) - 1]['id'];

        $product = [
            'id' => $lastId + 1,
            'title' => $data['title'],
            'price' => $data['price'],
            'created_at' => date('Y-m-d H:i:s'),
        ];

        array_push($items, $product);

        $jsonData = json_encode($items, JSON_PRETTY_PRINT);

        file_put_contents($this->filePath, $jsonData);

        $this->logModel->createLog('Creación de producto');

        return $product;
    }

    public function remove($id)
    {
        $items = $this->getAll();

        if (isset($items)) {
            foreach ($items as $index => $product) {
                if ($product['id'] === (int)$id) {
                    array_splice($items, $index, 1);
                    file_put_contents($this->filePath, json_encode($items, JSON_PRETTY_PRINT));

                    $this->logModel->createLog('Baja de producto');

                    return true;
                }
            }
        }

        throw new Exception("Something went wrong. Cant delete product");
    }

    public function modify($data)
    {
        $items = $this->getAll();

        $product = new \App\Entities\Product($data);

        if (isset($items)) {
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['id'] === (int)$product->id) {
                    $items[$i] = [
                        'id' => (int)$product->id,
                        'title' => $product->title,
                        'price' => $product->price,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    file_put_contents($this->filePath, json_encode($items, JSON_PRETTY_PRINT));
                    $this->logModel->createLog('Actualización de producto');

                    return true;
                }
            }
        }

        throw new Exception("Something went wrong. Cant modify product");
    }

    static function getLastIdProduct()
    {
        $items = (new ProductModel())->getAll();
        
        return $items[count($items) - 1]['id'];
    }
}
