<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RuleRepository")
 */
class Rule
{
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
     * @ORM\Column(type="string", length=100)
     */
    private $action_name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount_amount;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $discount_step;

    /**
     * Rule constructor.
     * @param $name
     * @param $action_name
     * @param $discount_amount
     * @param $discount_step
     */
    public function __construct(string $name, string $action_name, float $discount_amount = null, int $discount_step = null)
    {
        $this->name = $name;
        $this->action_name = $action_name;
        $this->discount_amount = $discount_amount;
        $this->discount_step = $discount_step;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
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

    public function getDiscountAmount(): ?float
    {
        return $this->discount_amount;
    }

    public function setDiscountAmount(?float $discount_amount): self
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
}
