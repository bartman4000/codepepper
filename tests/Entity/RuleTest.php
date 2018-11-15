<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\Entity;


use App\Discount\BuyXGetOne;
use App\Entity\Rule;
use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    public function testGetDiscount()
    {
        $rule = new Rule('Buy 3 get one free', 'BuyXGetOne', null, 3);
        $discount = $rule->getDiscount();
        $this->assertInstanceOf(BuyXGetOne::class, $discount);
    }
}