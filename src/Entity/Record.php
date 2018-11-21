<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecordRepository")
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"comment": "账户"})
     */
    private $account;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"comment": "描述"})
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"comment": "分类"})
     */
    private $category;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime", options={"comment": "日期时间"})
     */
    private $datetime;

    /**
     * @var float
     * @ORM\Column(type="float", options={"comment": "金额"})
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"comment": "货币"})
     */
    private $currency;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"comment": "标签"})
     */
    private $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDatetime(): \DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getTags(): string
    {
        return $this->tags;
    }

    public function setTags(string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }
}
