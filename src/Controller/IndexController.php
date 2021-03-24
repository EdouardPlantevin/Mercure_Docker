<?php 

namespace App\Controller;

use App\Entity\User;
use App\Mercure\CookieGenerator;
use App\Repository\UserRepository;
use Symfony\Component\Mercure\Update;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CookieGenerator $cookieGenerator, UserRepository $userRepository): Response
    {  
        return $this->render('index/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/ping/{user}", name="ping", methods={"POST"})
     */
    public function ping($user, MessageBusInterface $bus, UserRepository $userRepository)
    {
        $user = $userRepository->find($user);
        $update = new Update("http://monsite.com/ping/{$user->getId()}", "[]");

        $bus->dispatch($update);

        return $this->redirectToRoute('home');
    }
}