<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class ProductController extends Controller
{
    /**
     * @Route("/product/{page}", name="product", requirements={"page"="\d+"})
     */
    public function index($page = 1)
    {
        $products = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->getListProducts($page);

        dump($products);

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }
}
