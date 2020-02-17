<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */

class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(name="code", type="string", length=10, unique=true)
     * @Assert\NotBlank
     * @Assert\Type(type="alnum")
     */
    private $code;
    /**
     * @ORM\Column(name="name", type="string", unique=true)
     * @Assert\NotBlank
     */
    private $name;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $brand;
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $price;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @Assert\NotBlank
     */
    private $category;


    public function getCode()
    {
        return $this->code;
    }


    public function setCode($code): void
    {
        $this->code = $code;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name): void
    {
        $this->name = $name;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description): void
    {
        $this->description = $description;
    }


    public function getBrand()
    {
        return $this->brand;
    }


    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }


    public function getPrice()
    {
        return $this->price;
    }


    public function setPrice($price): void
    {
        $this->price = $price;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}