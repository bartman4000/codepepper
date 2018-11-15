<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\Service;


use App\Entity\Product;
use App\Entity\Rule;
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

    public function testCalculate_Buy2TshirtsGetOneFree()
    {
        $checkout = new CheckoutService();

        $rule = new Rule('Buy 2 Tshirts Get One Free', 'BuyXGetOne', null, 2);

        $products = [
            new Product("TSHIRT0011", 120, [$rule]),
            new Product("TSHIRT0011", 120, [$rule]),
            new Product("TSHIRT0011", 120, [$rule])
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(240, $total);
    }

    public function testCalculate_Buy1TshirtGetOneFree()
    {
        $checkout = new CheckoutService();

        $rule = new Rule('Buy 1 Tshirt Get One Free', 'BuyXGetOne', null, 1);

        $products = [
            new Product("TSHIRT0011", 120, [$rule]),
            new Product("TSHIRT0011", 120, [$rule])
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(120, $total);
    }

    public function testCalculate_Buy2CarsGet3rdFor60Percent()
    {
        $checkout = new CheckoutService();

        $rule = new Rule('Buy 2 Cars Get 3rd For 60%', 'BuyXGetNextDiscounted', 40, 2);

        $products = [
            new Product("CARTOYW0200", 300, [$rule]),
            new Product("CARTOYW0200", 300, [$rule]),
            new Product("CARTOYW0200", 300, [$rule]),
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(780, $total);
    }

    public function testCalculate_Buy1TshirtGetOneFree_Buy2CarsGet3rdFor40Percent_()
    {
        $checkout = new CheckoutService();

        $rule1 = new Rule('Buy 1 Tshirt Get One Free', 'BuyXGetOne', null, 1);
        $rule2 = new Rule('Buy 2 Cars Get 3rd For 50%', 'BuyXGetNextDiscounted', 50, 2);

        $products = [
            new Product("TSHIRT0011", 120, [$rule1]),
            new Product("TSHIRT0011", 120, [$rule1]),
            new Product("CARTOYW0200", 300, [$rule2]),
            new Product("CARTOYW0200", 300, [$rule2]),
            new Product("CARTOYW0200", 300, [$rule2]),
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(870, $total);
    }

    public function testCalculate_Buy2CarsGet3rdFor50Percent_And5thForFree()
    {
        $checkout = new CheckoutService();

        $rule1 = new Rule('Buy 2 Cars Get 3rd For 50%', 'BuyXGetNextDiscounted', 50, 2);
        $rule2 = new Rule('Buy 4 Cars Get One Free', 'BuyXGetOne', null, 4);

        $products = [

            new Product("CARTOYW0200", 300, [$rule1, $rule2]),
            new Product("CARTOYW0200", 300, [$rule1, $rule2]),
            new Product("CARTOYW0200", 300, [$rule1, $rule2]),
            new Product("CARTOYW0200", 300, [$rule1, $rule2]),
            new Product("CARTOYW0200", 300, [$rule1, $rule2]),
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(1050, $total);
    }

    public function testCalculate_GetEvery3rdDiscountedBy50Percent()
    {
        $checkout = new CheckoutService();
        $rule1 = new Rule('Buy 2 Cars Get 3rd For 50%', 'BuyXGetNextDiscounted', 50, 2);
        $products = [
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1]),
            new Product("TSHIRT01", 100, [$rule1])
        ];

        $total = $checkout->calculate($products);
        $this->assertEquals(750, $total);
    }
}