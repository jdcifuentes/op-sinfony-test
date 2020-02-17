<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    public function index()
    {
        $products = array(
            [
                'id' => 1,
                'code' => 'SKU',
                'name' => 'SKU',
                'description' => 'SKU',
                'brand' => 'SKU',
                'category_id' => 'SKU',
                'price' => 120000,
            ]
        );
        return $this->render('products/index.html.twig', array('products' => $products));
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function delete()
    {

    }

}