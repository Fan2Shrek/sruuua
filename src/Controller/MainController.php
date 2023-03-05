<?php

namespace App\Controller;

use App\Trait\TwigTrait;
use App\Database\Connection;
use App\Kernel;
use Sruuua\Routing\Interface\ControllerInterface;
use Sruuua\Routing\Route;
use Twig\Environment;

class MainController implements ControllerInterface
{
    use TwigTrait;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/')]
    public function index()
    {
        echo $this->twig->render('index.html.twig', ['message' => 'to sruuua ^^']);
    }
}
