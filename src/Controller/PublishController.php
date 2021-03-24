<?php

namespace App\Controller;

use Symfony\Component\Mercure\Update;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublishController extends AbstractController
{
    /**
     * @Route("/message", name="sendMessage", methods={"POST"})
     */
    public function __invoke(MessageBusInterface $bus, Request $request)
    {
        $update = new Update('http://chat.eyefiz.fr/message', json_encode([
            'message' => $request->request->get('message'),
        ]));
        $bus->dispatch($update);

        return $this->redirectToRoute('home');
    }
}