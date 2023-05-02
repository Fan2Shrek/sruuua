<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Trait\TwigTrait;
use Sruuua\Routing\Interface\ControllerInterface;
use Sruuua\Routing\Route;
use Twig\Environment;

class MainController implements ControllerInterface
{
    use TwigTrait;

    private UserRepository $userRepository;

    public function __construct(Environment $twig, UserRepository $userRepository)
    {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
    }

    #[Route('/')]
    public function index()
    {
        dsqdqs
        throw new \Exception('erreur jose');
        echo $this->twig->render('index.html.twig', ['message' => 'to sruuua ^^']);
    }
}
