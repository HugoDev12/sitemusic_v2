<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\MessagesRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{

    #[Route('/mailbox', name: 'app_mailbox')]
    public function getMailBox(MessagesRepository $messages, EntityManagerInterface $em): Response
    {
        $mailbox = $em->getRepository(Messages::class)->findBy(["recipient" => $this->getUser()],
        array('created_at' => 'DESC'));

        return $this->render('messages/mailbox.html.twig', [
            'messages' =>  $mailbox
        ]);
    }

    #[Route('/mailbox/{id}', name: 'app_readMessage')]
    public function changeMessageStatus(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $message = $em->getRepository(Messages::class)->find($id);
        $message->setRead(true);
        $em->persist($message);
        $em->flush();


        $answer = $request->request->get('messageContent');

        if(isset($answer) && !empty($answer)){

            $securedMessageContent = htmlspecialchars($answer);
            $newMessage = new Messages;
            $newMessage->setContent($securedMessageContent);
            $newMessage->setRecipient($message->getSender());
            $newMessage->setSender($this->getUser());
            $newMessage->setCreatedAt(new DateTime());

            $em->persist($newMessage);
            $em->flush();

            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute("app_advertisement");

        }

        $messageInfo = $message; // à continuer, fil de discussion etc...

        return $this->render('messages/thread.html.twig', [
            'messageContent' => $messageInfo // à continuer, fil de discussion etc...
        ]);
    }

        

    // #[Route('/admin/messages', name: 'app_admin_messages')]
    // public function adminMessages(EntityManagerInterface $em): Response
    // {
    //     $listMessages = $em->getRepository(Messages::class)->findAll();

    //     return $this->render('home/adminMessages.html.twig', [
    //         'messages'=> $listMessages
    //     ]);
    // }

    // #[Route('/admin/message-delete-{id}', name: 'app_admin_deleteMessage')]
    // public function adminEditMessage(int $id, EntityManagerInterface $em): Response
    // {
    //     $targetMessage = $em->getRepository(Messages::class)->find($id);
    //     $em->remove($targetMessage);
    //     $em->flush();

    //     $this->addFlash('info','Le message a bien été supprimé');

    //     return $this->redirectToRoute("app_admin_messages");
    // }

}
