<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\Service;


use App\Entity\Product;
use App\Service\CheckoutService;
use PHPUnit\Framework\TestCase;

class CheckoutServiceTest extends TestCase
{
    public function testCalculate_whenNoRules()
    {
        $checkout = new CheckoutService();

        $products = [
            new Product("TSHIRT0011", 120),
            new Product("TSHIRT0011", 120),
            new Product("CARTOYR0200", 300),
            new Product("CARTOYW0201", 320),
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(860, $total);
    }
}