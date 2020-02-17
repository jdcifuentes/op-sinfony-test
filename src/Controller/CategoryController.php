<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    /**
     * @Route("/categories", methods={"GET","HEAD"})
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('categories/index.html.twig', array('categories' => $categories));
    }


    /**
     * @Route("/categories/{id}", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Category $category)
    {
        return $this->render('categories/show.html.twig', array('category' => $category));
    }

    /**
     * @Route("/categories/new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            try {
                $entityManager->flush();

            } catch (ConstraintViolationException $exception) {
                //TODO: Set message to the user pointing the failure
                return $this->render('categories/new.html.twig', array('form' => $form->createView()));
            }

            return $this->redirectToRoute('app_category_index');
        }
        return $this->render('categories/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/categories/{id}/edit")
     */
    public function edit(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            try {
                $entityManager->flush();

            } catch (ConstraintViolationException $exception) {
                //TODO: Set message to the user pointing the failure
                return $this->render('categories/edit.html.twig', array('form' => $form->createView()));
            }

            return $this->redirectToRoute('app_category_index');
        }
        return $this->render('categories/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/categories/{id}/toggle-active", methods={"PATCH"})
     */
    public function toggleActive(Category $category)
    {
        $category->setActive(!$category->getActive());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        try {
            $entityManager->flush();
            return new JsonResponse(['message' => 'Ok']);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => 'Error'], 500);
        }
    }

    /**
     * @Route("/categories/{id}/delete", methods={"DELETE"})
     */
    public function delete(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        try {
            $entityManager->flush();
            return new JsonResponse(['message' => 'Ok']);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => 'Error'], 500);
        }
    }

}