<?php

namespace App\Entity;

use App\Discount\DiscountInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RuleRepository")
 */
class Rule
{

    const DISCOUNT_CLASS_PATH = 'App\\Discount\\';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discount_amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discount_step;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="rules")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;

    /**
     * Rule constructor.
     * @param $name
     * @param $action_name
     * @param $discount_amount
     * @param $discount_step
     */
    public function __construct(string $name, string $action_name, ?int $discount_amount=null, ?int $discount_step=null)
    {
        $this->name = $name;
        $this->action_name = $action_name;
        $this->discount_amount = $discount_amount;
        $this->discount_step = $discount_step;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getActionName(): ?string
    {
        return $this->action_name;
    }

    public function setActionName(string $action_name): self
    {
        $this->action_name = $action_name;

        return $this;
    }

    public function getDiscountAmount(): ?int
    {
        return $this->discount_amount;
    }

    public function setDiscountAmount(?int $discount_amount): self
    {
        $this->discount_amount = $discount_amount;

        return $this;
    }

    public function getDiscountStep(): ?int
    {
        return $this->discount_step;
    }

    public function setDiscountStep(?int $discount_step): self
    {
        $this->discount_step = $discount_step;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return DiscountInterface
     */
    public function getDiscount(): DiscountInterface
    {
        $name = $this->getActionName();
        $cname = self::DISCOUNT_CLASS_PATH.$name;
        return new $cname;
    }

    public static function fromArray(array $array): Rule
    {
        return new Rule(
            $array['name'],
            $array['action_name'],
            $array['discount_amount'],
            $array['discount_step']
        );
    }
}
