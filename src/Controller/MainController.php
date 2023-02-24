<?php

namespace App\Controller;

use App\Interface\ControllerInterface;
use App\Trait\TwigTrait;
use Sruuua\Routing\Route;

class MainController implements ControllerInterface{

    use TwigTrait;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    #[Route('/')]
    public function index(){
        echo $this->twig->render('index.html.twig', ['message' => 'Index']);
    }
}