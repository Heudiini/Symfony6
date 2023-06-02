<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController

{
  private array $messages = [
    "Hello", "Hi", "Bye!"
  ];
   #[Route('/{limit?3}', name: 'app_index')]
  public function index(int $limit): Response
{
  // instead of returning new instance of the response class,we can use helper method called render, that can use twig templating engine,
    return $this->render(
        'hello/index.html.twig',
        [
            // this variable "message" is going to be passed inside {{}} in the twig file
     
            'message' => implode(',', array_slice($this->messages, 0, $limit))
        ]
    );
}

  #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
  public function showOne(int $id): Response
  {
      return $this->render(
        // takes two arguments inside '', : name of the template file, path
      'hello/show_one.html.twig',
      [

        // this variable "message" is also going to be passed inside {{}} in the twig file
        'message' => $this->messages[$id]
      ]
    );
    // return new Response($this->messages[$id]);
  }
}
/*
#Its better to name all routes, as it's way more easier to redirect and link the when path is not needed.
#Best way to create routes is to use PHP attributes, give them names. In this code I have also created route parameters.
In this line, {id} is the route parameter placeholder. It specifies that the route expects a dynamic value for the id parameter. This means that when a request is made to a URL that matches this route pattern, the value provided in the URL will be assigned to the $id parameter in the showOne() method.
*/