<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\Entity\Discount;


use App\Entity\Discount\BuyXgetOne;
use App\Entity\Product;
use App\Entity\Rule;
use PHPUnit\Framework\TestCase;


class BuyXgetOneTest extends TestCase
{

    public function testCalculate_returnPrice0whenQuantity0()
    {
        $discount = new BuyXgetOne();
        $rule = new Rule('Buy 3 get one free', 'buy_x_get_y', null, 3);
        $price = $discount->calculate($rule, new Product('whatever', 12), 0);
        $this->assertEquals(0, $price->getAmount());
    }

    public function testCalculate_returnOriginalPriceWhenRuleStepUndefined()
    {
        $discount = new BuyXgetOne();
        $rule = new Rule('Buy 3 get one free', 'buy_x_get_y');
        $price = $discount->calculate($rule, new Product('whatever', 12), 2);
        $this->assertEquals(12, $price->getAmount());
    }

    public function testCalculate_returnPriceZeroWhenStep3andQuantity4()
    {
        $discount = new BuyXgetOne();
        $rule = new Rule('Buy 3 get one free', 'buy_x_get_y', null, 3);
        $price = $discount->calculate($rule, new Product('whatever', 12), 4);
        $this->assertEquals(0, $price->getAmount());
    }

    public function testCalculate_returnPriceZeroWhenStep3andQuantity8()
    {
        $discount = new BuyXgetOne();
        $rule = new Rule('Buy 3 get one free', 'buy_x_get_y', null, 3);
        $price = $discount->calculate($rule, new Product('whatever', 12), 8);
        $this->assertEquals(0, $price->getAmount());
    }
}