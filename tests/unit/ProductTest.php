<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\ProductModel;

/**
 * @internal
 */
final class ProductTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateProductSuccess()
    {
        $response = $this->call('post', '/product', [
            'title' => 'Test Product',
            'price' => 99.99,
        ]);
  
        $testOk = strpos($response->getBody(), '"status":true') > 0 ? true : false;

        $this->assertTrue($testOk);
        
        $response->assertStatus(200);
    }

    
    public function testDeleteProductSuccess()
    {
        $id = ProductModel::getLastIdProduct();

        $response = $this->call('post', '/product-delete', ['id' => $id]);
        
        $testOk = strpos($response->getBody(), '"status":true') > 0 ? true : false;

        $this->assertTrue($testOk);

        $response->assertStatus(200);
    }

    public function testDeleteProductIdNotExist()
    {
        $response = $this->call('post', '/product-delete', ['id' => 1]);
        
        $testOk = strpos($response->getBody(), '"status":true') > 0 ? true : false;

        $this->assertFalse($testOk);

        $response->assertStatus(200);
    }
}
