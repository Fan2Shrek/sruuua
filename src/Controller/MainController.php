<?php

namespace App\Controller;

use App\Validator\Validator;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Trait\TwigTrait;
use Sruuua\Routing\Interface\ControllerInterface;
use Sruuua\Routing\Route;
use Twig\Environment;

class MainController implements ControllerInterface
{
    use TwigTrait;

    private UserRepository $userRepository;

    private Validator $validator;

    public function __construct(Environment $twig, UserRepository $userRepository, Validator $validator)
    {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    #[Route('/')]
    public function index()
    {
        $user = new User();
        $user = $user->setId(0)->setEmail('')->setPassword('');
        $rep = $this->validator->validate($user);
        dd($rep);
        echo $this->twig->render('index.html.twig', ['message' => 'to sruuua ^^']);
    }
}
