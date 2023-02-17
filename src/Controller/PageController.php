<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;

use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\Tag;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
  #[Route('/', name: 'app_home')]
  public function home(Request $request, TagRepository $tagRepository, ProductRepository $productRepository): Response
  {
    $tag = null;

    if ($request->get('tag')) {
      $tag = $tagRepository->findOneBy(['name' => $request->get('tag')]);
    }

    return $this->render(
      'page/home.html.twig',
      [
        'title' => 'Home',
        'products' => $productRepository->findLatest($tag)
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

  #[Route('/comments', name: 'app_comments')]
  public function comments(CommentRepository $commentRepository): Response
  {
    return $this->render(
      'comments/index.html.twig',
      [
        'title' => 'Comments',
        'comments' => $commentRepository->findAllComments()
      ]
    );
  }
}
