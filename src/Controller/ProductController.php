<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    /**
     * @Route("/", methods={"GET","HEAD"})
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAllActive();
        return $this->render('products/index.html.twig', array('products' => $products));
    }


    /**
     * @Route("/products/{id}", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Product $product)
    {
        return $this->render('products/show.html.twig', array('product' => $product));
    }

    /**
     * @Route("/products/new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            try {
                $entityManager->flush();

            } catch (ConstraintViolationException $exception) {
                //TODO: Set message to the user pointing the failure
                return $this->render('products/new.html.twig', array('form' => $form->createView()));
            }

            return $this->redirectToRoute('app_product_index');
        }
        return $this->render('products/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/products/{id}/edit")
     */
    public function edit(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            try {
                $entityManager->flush();

            } catch (ConstraintViolationException $exception) {
                //TODO: Set message to the user pointing the failure
                return $this->render('products/edit.html.twig', array('form' => $form->createView()));
            }

            return $this->redirectToRoute('app_product_index');
        }
        return $this->render('products/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/products/{id}/edit", methods={"DELETE"})
     */
    public function delete(Product $product)
    {

    }

}