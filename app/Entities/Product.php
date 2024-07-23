<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    protected $attributes = [
        'id'         => null,
        'title'  => null, // In the $attributes, the key is the db column name
        'price'      => null,
        'created_at' => null,
    ];
}
