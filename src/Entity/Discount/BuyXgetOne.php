<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Entity\Discount;


use App\Entity\DiscountInterface;
use App\Entity\Price;
use App\Entity\Product;
use App\Entity\Rule;

class BuyXgetOne implements DiscountInterface
{

    public function calculate(Rule $rule, Product $product, int $quantity): Price
    {
        $price = new Price($product->getPrice());

        if($quantity === 0) {
            return new Price(0);
        }

        $x = $rule->getDiscountStep();

        if(empty($x)) {
            return new Price($product->getPrice());
        }

        $mod = ($quantity % ($x+1));
        if($mod == 0) {
            return new Price(0);
        }

        return $price;
    }
}