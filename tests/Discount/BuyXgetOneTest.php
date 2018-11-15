<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\Entity\Discount;


use App\Discount\BuyXGetOne;

use App\Entity\Product;
use App\Entity\Rule;
use PHPUnit\Framework\TestCase;


class BuyXgetOneTest extends TestCase
{

    public function testCalculate_returnPrice0whenQuantity0()
    {
        $discount = new BuyXGetOne();
        $rule = new Rule('Buy 3 get one free', 'buyXGetOne', null, 3);
        $price = $discount->calculate($rule, new Product('whatever', 12), 0);
        $this->assertEquals(0, $price->getAmount());
    }

    public function testCalculate_returnOriginalPriceWhenRuleStepUndefined()
    {
        $discount = new BuyXGetOne();
        $rule = new Rule('Buy 3 get one free', 'buyXGetOne');
        $price = $discount->calculate($rule, new Product('whatever', 12), 2);
        $this->assertEquals(12, $price->getAmount());
    }

    public function testCalculate_returnPriceZeroWhenStep3andQuantity4()
    {
        $discount = new BuyXGetOne();
        $rule = new Rule('Buy 3 get one free', 'buyXGetOne', null, 3);
        $price = $discount->calculate($rule, new Product('whatever', 12), 4);
        $this->assertEquals(0, $price->getAmount());
    }

    public function testCalculate_returnPriceZeroWhenStep3andQuantity8()
    {
        $discount = new BuyXGetOne();
        $rule = new Rule('Buy 3 get one free', 'buyXGetOne', null, 3);
        $price = $discount->calculate($rule, new Product('whatever', 12), 8);
        $this->assertEquals(0, $price->getAmount());
    }
}