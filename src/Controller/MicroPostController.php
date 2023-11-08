<?php

namespace App\Controller;

use App\Entity\Comment;

use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
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
            'posts' => $posts->findAllWithComments(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
             'post' => $post,
        ]);
    }

#[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
public function add(Request $request, MicroPostRepository $posts): Response {
    $microPost = new MicroPost();
    $form = $this->createForm(MicroPostType::class, $microPost);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Set the current logged-in user as the author of the microPost
        $microPost->setAuthor($this->getUser());
        $microPost->setCreated(new DateTime());
        
        $posts->add($microPost, true);

        $this->addFlash('success', 'Your micro post was added');
        return $this->redirectToRoute('app_micro_post');
    }

    return $this->render('micro_post/add.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response {
    $form = $this->createForm(MicroPostType::class, $post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Assuming the author should not change during edit, so not setting it again.
        // If the author can change, you must handle it here appropriately.
        
        $posts->add($post, true);

        $this->addFlash('success', 'Your micro post was edited');
        return $this->redirectToRoute('app_micro_post');
    }

    return $this->render('micro_post/edit.html.twig', [
        'form' => $form->createView(),
        'post' => $post
    ]);
}



///comments 
#[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
public function addComment(MicroPost $post, Request $request, EntityManagerInterface $entityManager): Response
{
    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $comment->setPost($post);

        // Set the author of the comment to the current user
        $comment->setAuthor($this->getUser());

        // Persist the comment using EntityManager
        $entityManager->persist($comment);
        $entityManager->flush();

        // Add a flash message
        $this->addFlash('success', 'Your comment was updated');

        // Redirect to the micro post page
        return $this->redirectToRoute('app_micro_post_show', ['post' => $post->getId()]);
    }

    // Render the comment form
    return $this->render('micro_post/comment.html.twig', [
        'form' => $form->createView(),
        'post' => $post
    ]);
}

}
