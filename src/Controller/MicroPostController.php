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
    public function index(MicroPostRepository $posts): Response
    {
        // Get all MicroPosts
        $allPosts = $posts->findAll();
        dd($allPosts);

        return $this->render('micro_post/index.html.twig', [
            'posts' => $allPosts,
        ]);
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    public function showOne($id, MicroPostRepository $posts): Response
    {
        // Get a specific MicroPost by ID
        $post = $posts->find($id);
        dd($post);

        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
