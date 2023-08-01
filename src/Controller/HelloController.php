<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\UserProfileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;
class HelloController extends AbstractController
{
  private array $messages = [
   
     ['message' => 'Hello', 'created' => '2023/05/12'],
    ['message' => 'Hi', 'created' => '2023/03/12'],
    ['message' => 'Bye!', 'created' => '2021/05/12']
  ];
 #[Route('/', name: 'app_index', requirements: ['limit' => '\d+'])]

   public function index(EntityManagerInterface $entityManager): Response

  {

    $user = new User();
    $user -> setEmail('email3@email.com');
    $user -> setPassword('4423456');

    $profile = new UserProfile();
    $profile-> setUser($user);
     // Get the Doctrine entity manager and persist the User and UserProfile objects
        $entityManager->persist($user);
        $entityManager->persist($profile);

        // Flush the changes to the database
        $entityManager->flush();


    return $this->render(
      'hello/index.html.twig',
      [
        'messages' => $this->messages,
        'limit' => 3
      ]
    );
  }
  #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
  public function showOne(int $id): Response
  {
    return $this->render(
      'hello/show_one.html.twig',
      [
        'message' => $this->messages[$id]
      ]
    );
    // return new Response($this->messages[$id]);
  }
}
