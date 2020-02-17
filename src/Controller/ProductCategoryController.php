<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductCategoryController extends AbstractController
{

    public function index()
    {
        return $this->render('products/index.html.twig');
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