<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class MainController extends BaseController
{
    
    public function home(RouterInterface $router) : Response
    {
        return $this->render('home.twig', [
            'routes' => $router->getRouteCollection()->all()
        ]);
    }
    
}
