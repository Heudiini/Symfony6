<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
  private array $messages = [
    "Hello", "Hi", "Bye!"
  ];

  #[Route('/', name: 'app_index')]
public function index(): Response
{
    return new Response(implode(',', $this->messages));
  }

  #[Route('/messages/{id}', name: 'app_show_one')]
  public function showOne($id): Response
  {
    return new Response($this->messages[$id]);
  }
}
/*
#Its better to name all routes, as it's way more easier to redirect and link the when path is not needed.
#Best way to create routes is to use PHP attributes, give them names. In this code I have also created route parameters.
In this line, {id} is the route parameter placeholder. It specifies that the route expects a dynamic value for the id parameter. This means that when a request is made to a URL that matches this route pattern, the value provided in the URL will be assigned to the $id parameter in the showOne() method.
*/