<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    /**
     * @Route("/", methods={"GET","HEAD","POST"})
     */
    public function index(Request $request, DataTableFactory $dataTableFactory)
    {
        $table = $dataTableFactory->create()
            ->add('code', TextColumn::class, ['label' => 'Código'])
            ->add('name', TextColumn::class, ['label' => 'Nombre'])
            ->add('description', TextColumn::class, ['label' => 'Descripción'])
            ->add('brand', TextColumn::class, ['label' => 'Marca'])
            ->add('category', TextColumn::class, ['field' => 'category.name', 'label' => 'Categoría'])
            ->add('price', TextColumn::class, ['label' => 'Precio'])
            ->add('id', TwigColumn::class, [
                'orderable' => false,
                'label' => '',
                'className' => 'buttons',
                'template' => 'products/buttonbar.html.twig',
            ])
            ->createAdapter(ORMAdapter::class, [
                    'entity' => Product::class,
                    'query' => function (QueryBuilder $builder) {
                        $builder
                            ->select('product')
                            ->from(Product::class, 'product')
                            ->join('product.category', 'category')
                            ->andWhere('category.active = :val')
                            ->setParameter('val', 1);
                    }]
            )
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        $products = $this->getDoctrine()->getRepository(Product::class)->findAllActive();
        return $this->render('products/index.html.twig', array('products' => $products, 'datatable' => $table));
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
     * @Route("/products/{id}/delete", methods={"DELETE"})
     */
    public function delete(Product $product)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        try {
            $entityManager->flush();
            return new JsonResponse(['message' => 'Ok']);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => 'Error'], 500);
        }
    }

}