<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    #[Route('/tags', name: 'app_tags')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tags = $entityManager->getRepository(Tag::class)->findAll();

        return $this->render('tag/index.html.twig', [
            'title' => 'Tags',
            'tags' => $tags
        ]);
    }
}
