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
    {/* 
        $microPost = new MicroPost();

        $microPost->setTitle('From controller');
        $microPost->setText('Moi');
        $microPost->setCreated(new DateTime());

*/
        $microPost = $posts->find(5); 
       //$microPost->setTitle('From id 3');
        $posts->remove($microPost, true); 
        $entityManager->persist($microPost);
        $entityManager->flush();
        
        //dd($posts->findBy(['title' => 'Welcome to Tenerife!']));
        return $this->render('micro_post/index.html.twig', [
            'controller_name' => 'MicroPostController',
        ]);
    }
}
