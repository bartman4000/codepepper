<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Service;


use App\Entity\Product;

class CheckoutService
{
    /**
     * @param Product[] $products
     */
    public function calculate(array $products): float
    {
        $total = 0;
        foreach ($products as $product) {
            if(!$product instanceof Product) {
                continue;
            }

            $quantity = [];

            $sku = $product->getSku();
            if(isset($quantity[$sku])) {
                $quantity[$sku] ++;
            } else {
                $quantity[$sku] = 1;
            }

            foreach ($product->getRules() as $rule) {
                $discount = $rule->getDiscount();
                $price = $discount->calculate( $rule, $product, $quantity[$sku]);
                $product->setPrice($price->getAmount());
            }

            $total += $product->getPrice();
        }
        return $total;
    }
}