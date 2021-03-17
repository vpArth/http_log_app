<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
  /** @Route("/") */
  public function echoAction(Request $request)
  {
    return $this->json([
        'method' => $request->getMethod(),
        'uri'    => $request->getUri(),
        'query'  => $request->query->all(),
        'request' => $request->request->all(),
        'attributes' => $request->attributes->all()
    ]);
  }
}
