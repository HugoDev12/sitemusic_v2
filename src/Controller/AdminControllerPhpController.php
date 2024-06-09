<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Advertisement;
use App\Entity\Messages;

class AdminControllerPhpController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function adminDashboard(EntityManagerInterface $em): Response
    {
   
        $listUsers = $em->getRepository(User::class)->findAll();

        return $this->render('admin/admin.html.twig', [
            'users'=> $listUsers
        ]);
    }

    #[Route('/admin/advertisements', name: 'app_admin_advertisements')]
    public function adminAdvertisements(EntityManagerInterface $em): Response
    {
        $listAdvertisements = $em->getRepository(Advertisement::class)->findAll();

        return $this->render('admin/adminAdvertisements.html.twig', [
            'advertisements'=> $listAdvertisements
        ]);
    }


    #[Route('admin/advertisement-delete-{id}', name: 'app_admin_deleteAdv')]
    public function adminDeleteAdv(int $id, EntityManagerInterface $em)
    {
        $advToDelete = $em->getRepository(Advertisement::class)->find($id);

        $em->remove($advToDelete);
        $em->flush();

        $this->addFlash('info', 'L\'annonce a bien été supprimé');

        return $this->redirectToRoute('app_admin_advertisements'); 
    }


    #[Route('/admin/messages', name: 'app_admin_messages')]
    public function adminMessages(EntityManagerInterface $em): Response
    {
        $listMessages = $em->getRepository(Messages::class)->findAll();

        return $this->render('admin/adminMessages.html.twig', [
            'messages'=> $listMessages
        ]);
    }

    #[Route('/admin/message-delete-{id}', name: 'app_admin_deleteMessage')]
    public function adminEditMessage(int $id, EntityManagerInterface $em): Response
    {
        $targetMessage = $em->getRepository(Messages::class)->find($id);
        $em->remove($targetMessage);
        $em->flush();

        $this->addFlash('info','Le message a bien été supprimé');

        return $this->redirectToRoute("app_admin_messages");
    }

    #[Route('/user/profile/delete/{id}', name: 'app_user_delete_profile')]
    public function deleteUser(int $id, EntityManagerInterface $em): Response
    {

        if($this->getUser()->getId() !== $id && !in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
            return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
        } // ok

        $user = $em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();

        $this->addFlash('info','Le profil a bien été supprimé');

        return $this->redirectToRoute("app_admin");
    }
}
