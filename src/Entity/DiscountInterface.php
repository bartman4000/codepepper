<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Entity;


interface DiscountInterface
{
    public function calculate(Rule $rule, Product $product, int $quantity): Price;
}