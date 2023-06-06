<?php
namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts, EntityManagerInterface $entityManager): Response
    {
        // Uncomment the code below if you want to remove a MicroPost by ID
        /*
        $microPost = $posts->find(5);
        if ($microPost) {
            $entityManager->remove($microPost);
            $entityManager->flush();
        }
        */

        // Get all MicroPosts
        $allPosts = $posts->findAll();
        dd($allPosts);

        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
        ]);
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    public function showOne($id, MicroPostRepository $posts): Response
    {
        // Get a specific MicroPost by ID
        $post = $posts->find($id);
        dd($post);

        return new Response();
    }
}
