<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    private $filePath;

    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $this->filePath = APPPATH . '/Database/logs.json';
    }

    public function getAll()
    {
        $fileExist = file_exists($this->filePath);

        if (!$fileExist) {
            throw new Exception("File not found", 1);
        }

        $data = file_get_contents($this->filePath) ? file_get_contents($this->filePath) : '[]';

        return json_decode($data, true);
    }

    public function getAllPagination($limit, $offset)
    {
        $items = $this->getAll();

        return array_slice($items, $offset, $limit);
    }

    
    public function countAll()
    {
        $items = $this->getAll();

        return count($items); 
    }

    public function createLog($action)
    {
        $user = session()->get('username');

        if(!$user){
            $user = 'Visitante';
        }

        $data = [
            'user' => $user,
            'action' => $action,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $items = $this->getAll();

        if(!isset($items)) {
            $items = [];
        }

        array_push($items, $data);

        $jsonData = json_encode($items, JSON_PRETTY_PRINT);

        file_put_contents($this->filePath, $jsonData);
    }
}
