<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $code;
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $name;
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="string")
     */
    private $brand;
    /**
     * @ORM\Column(type="integer")
     */
    private $categoryId;
    /**
     * @ORM\Column(type="float")
     */
    private $price;
}