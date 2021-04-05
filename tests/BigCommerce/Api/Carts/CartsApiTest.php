<?php

namespace BigCommerce\Tests\Api\Carts;

use BigCommerce\ApiV3\ResourceModels\Cart\Cart;
use BigCommerce\Tests\BigCommerceApiTest;

class CartsApiTest extends BigCommerceApiTest
{
    public function testCanGetCart()
    {
        $this->setReturnData('carts_get.json');

        $id = 'aae435b7-e8a4-48f2-abcd-ad0675dc3123';
        $cart = $this->getApi()->cart($id)->get()->getCart();
        $this->assertEquals(1815, $cart->cart_amount);
        $this->assertEquals("carts/$id", $this->getLastRequest()->getUri()->getPath());
    }

    public function testCanCreateACart()
    {
        $this->setReturnData('carts_get.json', 201);
        $cart = new Cart();

        $this->getApi()->carts()->create($cart);
        $this->assertEquals("carts", $this->getLastRequest()->getUri()->getPath());
    }

    public function testCanUpdateCustomerIdForCart()
    {
        $this->setReturnData('carts_get.json', 201);
        $id = 'aae435b7-e8a4-48f2-abcd-ad0675dc3123';

        $this->getApi()->cart($id)->updateCustomerId(3);

        $this->assertEquals("carts/$id", $this->getLastRequest()->getUri()->getPath());
        $this->assertEquals(json_encode(['customer_id' => 3]), $this->getLastRequest()->getBody());
        $this->markTestIncomplete();
    }
}
