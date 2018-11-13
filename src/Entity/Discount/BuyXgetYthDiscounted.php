<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Entity\Discount;


use App\Entity\DiscountInterface;
use App\Entity\Price;
use App\Entity\Product;
use App\Entity\Rule;

class BuyXgetYthDiscounted implements DiscountInterface
{

    public function calculate(Rule $rule, Product $product, int $quantity): Price
    {
        $price = new Price($product->getPrice());

        if($quantity === 0) {
            return new Price(0);
        }

        $x = $rule->getDiscountStep();
        $discountPercent = $rule->getDiscountAmount();

        if(empty($x) || empty($discountPercent)) {
            return new Price($product->getPrice());
        }

        $mod = ($quantity % $x);
        if($mod == 0) {

            $amountToSubtract = ($discountPercent/100) * $product->getPrice();
            $newPrice = floor($product->getPrice() - $amountToSubtract);
            return new Price($newPrice);
        }

        return $price;
    }
}