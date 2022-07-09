<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\StockHistoric;
use App\Entity\User;
use App\Form\ProductsType;
use App\Form\StockType;
use App\Repository\ProductsRepository;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
class ProductsController extends AbstractController
{

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    #[Route('/', name: 'app_products_index', methods: ['GET'])]
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/new', name: 'app_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductsRepository $productsRepository): Response
    {
        $product = new Products();
        $em = $this->doctrine->getManager();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new DateTime());
            $em->persist($product);
            $em->flush();
            $productsRepository->add($product);
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('products/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productsRepository->add($product);
            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productsRepository->remove($product);
        }

        return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{producto}/stockManagement', name: 'app_products_stock_management', methods: ['GET', 'POST'])]
    public function stockManagement(Request $request, Products $producto): Response
    {
        $em = $this->doctrine->getManager();

        $user = $this->getUser();
        $user = $em->getRepository(User::class)->find($user->getId());

        $form = $this->createForm(StockType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cantidadCambio = $form['cantidad']->getData();
            $cantidadFinal = $producto->getStock() + $cantidadCambio;
            if ($cantidadFinal < 0)
                $cantidadFinal = 0;

            $producto->setStock($cantidadFinal);
            $em->persist($producto);

            // Añadimos histórico
            $stockHistoric = new StockHistoric();
            $stockHistoric->setUser($user);
            $stockHistoric->setProduct($producto);
            $stockHistoric->setStock($cantidadCambio); // <-- "La cantidad de productos añadidos o consumidos"
            $stockHistoric->setCreatedAt(new DateTime());
            $em->persist($stockHistoric);

            $em->flush();


            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('products/stockManagement.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{producto}/stockHistoric', name: 'app_products_stock_historic', methods: ['GET', 'POST'])]
    public function stockHistoric(Request $request, Products $producto): Response
    {
        $em = $this->doctrine->getManager();
        $user = $em->getRepository(User::class)->find($this->getUser()->getId());

        $stockHistorics = $em->getRepository(StockHistoric::class)->findBy(['user' => $user, 'product' => $producto]);

        return $this->render('products/stockHistoric.html.twig', [
            'producto' => $producto,
            'stockHistorics' => $stockHistorics
        ]);
    }
}
