<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use App\Service\ResponseErrorDecoratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class ProductController extends AbstractController
{
    private $productsApi;

    public function __construct(ProductApiController $productsApi)
    {
        $this->productsApi = $productsApi;
    }

    /**
     * @Route("/", name="product_index", methods={"GET"})
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        $collection = $this->productsApi->getProducts($productRepository);

        $collectionArray = json_decode($collection->getContent(), true);

        return $this->render('product/index.html.twig', [
            'products' => $collectionArray,
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     * @param Request $request
     * @param ProductService $productService
     * @param ResponseErrorDecoratorService $errorDecorator
     * @return Response
     */
    public function new(
        Request $request,
        ProductService $productService,
        ResponseErrorDecoratorService $errorDecorator): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $jsonFormData = json_encode($request->request->get('product'), true);

            $product = $this->productsApi->createProduct($jsonFormData, $productService, $errorDecorator);

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{issn}", name="product_show", methods={"GET"})
     * @param Product $product
     * @param ResponseErrorDecoratorService $errorDecorator
     * @return Response
     */
    public function show(Product $product, ResponseErrorDecoratorService $errorDecorator): Response
    {
        $response = $this->productsApi->getProduct($product, $errorDecorator);

        $productArray = json_decode($response->getContent(), true);

        return $this->render('product/show.html.twig', [
            'product' => $productArray,
        ]);
    }

    /**
     * @Route("/{issn}/edit", name="product_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Product $product
     * @param ProductService $productService
     * @param ResponseErrorDecoratorService $errorDecorator
     * @return Response
     */
    public function edit(
        Request $request,
        Product $product,
        ProductService $productService,
        ResponseErrorDecoratorService $errorDecorator): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $jsonFormData = json_encode($request->request->get('product'), true);

            $productResponse = $this->productsApi->updateProduct($product, $jsonFormData, $productService, $errorDecorator);

            return $this->redirectToRoute('product_index', [
                'issn' => $product->getIssn(),
            ]);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{issn}", name="product_delete", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @param ProductService $productService
     * @param ResponseErrorDecoratorService $errorDecorator
     * @return Response
     */
    public function delete(
        Request $request,
        Product $product,
        ProductService $productService,
        ResponseErrorDecoratorService $errorDecorator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getIssn(), $request->request->get('_token'))) {

            $response = $this->productsApi->deleteProduct($product, $productService, $errorDecorator);
        }

        return $this->redirectToRoute('product_index');
    }
}