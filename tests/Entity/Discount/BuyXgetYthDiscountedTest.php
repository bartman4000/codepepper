<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\Entity\Discount;


use App\Discount\BuyXgetYthDiscounted;
use App\Entity\Product;
use App\Entity\Rule;
use PHPUnit\Framework\TestCase;

class BuyXgetYthDiscountedTest extends TestCase
{
    public function testCalculate_returnPrice0whenQuantity0()
    {
        $discount = new BuyXgetYthDiscounted();
        $rule = new Rule('Get 3rd for 50% price', 'buy_x_get_yth_discounted', 50, 3);
        $price = $discount->calculate($rule, new Product('toy car', 100), 0);
        $this->assertEquals(0, $price->getAmount());
    }

    public function testCalculate_returnOriginalPriceWhenRuleStepUndefined()
    {
        $discount = new BuyXgetYthDiscounted();
        $rule = new Rule('Get 3rd for 50% price', 'buy_x_get_yth_discounted', 40);
        $price = $discount->calculate($rule, new Product('toy car', 100), 2);
        $this->assertEquals(100, $price->getAmount());
    }

    public function testCalculate_returnOriginalPriceWhenRuleAmountUndefined()
    {
        $discount = new BuyXgetYthDiscounted();
        $rule = new Rule('Get 3rd for 50% price', 'buy_x_get_yth_discounted', null, 3);
        $price = $discount->calculate($rule, new Product('toy car', 100), 2);
        $this->assertEquals(100, $price->getAmount());
    }

    public function testCalculate_return50PerPricefor3rdProductWhenRuleStep3andAmount50()
    {
        $discount = new BuyXgetYthDiscounted();
        $rule = new Rule('Get 3rd for 50% price', 'buy_x_get_yth_discounted', 50, 3);
        $price = $discount->calculate($rule, new Product('toy car', 100), 3);
        $this->assertEquals(50, $price->getAmount());
    }

    public function testCalculate_return40PerPricefor5thProductWhenRuleStep5andAmount40()
    {
        $discount = new BuyXgetYthDiscounted();
        $rule = new Rule('Get 5th for 40% price', 'buy_x_get_yth_discounted', 40, 5);
        $price = $discount->calculate($rule, new Product('toy car', 100), 5);
        $this->assertEquals(60, $price->getAmount());
    }

    public function testCalculate_returnFullPricefor4thProductWhenRuleStep4andQuantity3()
    {
        $discount = new BuyXgetYthDiscounted();
        $rule = new Rule('Get 4th for 40% price', 'buy_x_get_yth_discounted', 40, 4);
        $price = $discount->calculate($rule, new Product('toy car', 100), 3);
        $this->assertEquals(100, $price->getAmount());
    }
}