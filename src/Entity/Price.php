<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Entity;


class Price
{
    /**
     * @var float
     */
    protected $amount;

    /**
     * Price constructor.
     * @param $amount
     */
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }
}