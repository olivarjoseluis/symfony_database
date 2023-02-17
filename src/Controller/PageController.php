<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Tag;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(EntityManagerInterface $entityManager): Response
    {
        return $this->render(
            'page/home.html.twig',
            [
                'title' => 'Home',
                'products' => $entityManager->getRepository(Product::class)->findAll()
            ]
        );
    }

    #[Route('/tag/{id}', name: 'app_tag')]
    public function tag(Tag $tag): Response
    {
        return $this->render(
            'page/tag.html.twig',
            [
                'name' => $tag->getName(),
                'tag' => $tag
                //'products' => $tag->getProducts()
            ]
        );
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function product(Product $product): Response
    {
        return $this->render(
            'page/product.html.twig',
            [
                'title' => $product->getName(),
                'product' => $product
            ]
        );
    }
}
