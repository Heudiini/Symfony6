<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Routing\Annotation\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
       

        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
             'post' => $post,
        ]);
    }

#[Route('/micro-post/add', name: 'app_micro_post_add', methods: ['GET', 'POST'], priority: 2)]
public function add(Request $request, MicroPostRepository $posts): Response
{
    $microPost = new MicroPost();
    $form = $this->createFormBuilder($microPost)
        ->add('title')
        ->add('text')
        ->add('submit', SubmitType::class, ['label' => 'Save'])
        ->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $post = $form->getData();
        $post->setCreated(new DateTime());
        $posts->add($post, true);

        //add a flash
        $this->addFlash('success','Your micro post was added');
        return $this->redirectToRoute('app_micro_post');

        //redirect
    }

    return $this->render(
        'micro_post/add.html.twig',
        [
            'form' => $form->createView(),
        ]
    );
}
#[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
{
   
    $form = $this->createFormBuilder($post)
        ->add('title')
        ->add('text')
        ->add('submit', SubmitType::class, ['label' => 'Save'])
        ->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $post = $form->getData();
      
        $posts->add($post, true);

        //add a flash
        $this->addFlash('success','Your micro post was updated');
        return $this->redirectToRoute('app_micro_post');

        //redirect
    }
  // Render the add.html.twig template and pass the form and post as variables
   
    return $this->render(
        'micro_post/add.html.twig',
        [
            'form' => $form->createView(),
        ]
    );
}
}
