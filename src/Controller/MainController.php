<?php

namespace App\Controller;

use App\Interface\ControllerInterface;
use App\Kernel;
use App\Trait\TwigTrait;
use Sruuua\Routing\Route;
use Twig\Environment;

class MainController implements ControllerInterface
{

    use TwigTrait;

    public function __construct(Kernel $kernel, Route $joe)
    {
    }

    #[Route('/')]
    public function index()
    {
        echo $this->twig->render('index.html.twig', ['message' => 'Index']);
    }
}
