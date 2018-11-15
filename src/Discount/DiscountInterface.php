<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Discount;


use App\Entity\Price;
use App\Entity\Product;
use App\Entity\Rule;

interface DiscountInterface
{
    public function calculate(Rule $rule, Product $product, int $quantity): Price;
}