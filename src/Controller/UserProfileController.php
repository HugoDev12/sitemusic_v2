<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Security\AdvFormSecurity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProfileController extends AbstractController
{
    // private $messages;

    // public function __construct(MessagesRepository $messages)
    // {
    //     $this->messages = $messages;
        
    // }
    #[Route('/user/profile/{id}', name: 'app_user_profile')]
    public function editProfile(int $id, Request $request, EntityManagerInterface $em, SluggerInterface $slugger,AdvFormSecurity $isSecured, UserPasswordHasherInterface $passwordHasher ): Response
    {

        if($this->getUser()->getId() !== $id && !in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
            return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
        }

        $user = $em->getRepository(User::class)->find($id);
        $userAdvertisements = $em->getRepository(Advertisement::class)->findBy(["user" => $user]);
        $form = $this -> createForm(UserType::class, $user);

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        
            $datas = $form->getData();

            $securedInputs = $isSecured->checkFormUser($datas, $passwordHasher);

            $avatar = $form->get('avatar')->getData();

            if($securedInputs){

                if ($avatar) {
                    $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatar->guessExtension();

                    // remove old avatar if a new one is uploaded
                    $previousAvatar = $user->getAvatar();
                    
                    if(!empty($previousAvatar)){
                        unlink('../public/images_users/'.$previousAvatar);
                    }

                    // Move the file to the directory where brochures are stored
                    try {
                        $avatar->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $securedInputs->setAvatar($newFilename);
                }

                $securedInputs->setDate($user->getDate());
                $em->persist($securedInputs);
                $em->flush();

                $this->addFlash('success','Votre profil a bien été modifié');

                return $this->redirectToRoute("app_home");
            }
            else {

                $this->addFlash('warning', 'Données saisies non conformes');

                return $this->redirectToRoute('app_user_profile', ["id" => $this->getUser()->getId()]);
            }
        }
        
        // dd($userAdvertisements);
        return $this->render('user_profile/index.html.twig', [
            'controller_name' => 'UserProfileController',
            'form' => $form -> createView(),
            'user' => $user,
            'userAdvertisements' => $userAdvertisements,
            // 'countUnreadMsg'=> count($this->messages->getUnreadMessages($this->getUser()))
        
        ]);
    }

    #[Route('user/profile/visit/{pseudo}', name:'app_user_visit_profile')]
    public function viewProfile(string $pseudo, EntityManagerInterface $em): Response
    {
        $visitedUser = $em->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);

        // dd($visitedUser);

        return $this->render('user_profile/visitUser.html.twig', [
            'user' => $visitedUser
        ]);
    }


    
}
