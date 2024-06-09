<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AdvertisementRepository;
use App\Form\AdvancedSearchType;
use App\Entity\Advertisement;
use App\Security\AdvFormSecurity;
use App\Entity\User;
use App\Entity\Messages;
use App\Form\AdvertisementType;
use App\Repository\MessagesRepository;
use DateTime;


class AdvertisementController extends AbstractController
{
    #[Route('/advertisement/{region}', name: 'app_advertisement', methods:["GET", "POST"])] //, methods:["GET", "POST"]
    public function index(EntityManagerInterface $em, Request $request, AdvertisementRepository $advRepo, string $region=null): Response
    {
        $actualUser = $this->getUser(); 

        $form = $this->createForm(AdvancedSearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $datas = $form->getData();
            $researchParams = [];

            foreach($datas as $key => $data){
                if(!is_null($datas[$key])){
                    $researchParams[$key] = $datas[$key];
                } 
            }
            $searchResult = $advRepo->advancedSearchAd($datas["isAlone"], $datas["city"], $datas["pseudo"], $datas["lookingFor"]);

            return $this->render('advertisement/index.html.twig', [
                'advertisements' => $searchResult,
                'form' => $form->createView()
            ]); 
        }

        // dd($actualUser);
        if(!is_null($region)){
            $advertisements = $em->getRepository(Advertisement::class)->findBy(["region" => $region]);
        } else {
            $advertisements = $em->getRepository(Advertisement::class)->findAll();
        }

        // dd($advertisements);

        return $this->render('advertisement/index.html.twig', [
            'form' => $form->createView(),
            'advertisements' => $advertisements,
            'user' => $actualUser,
        ]);
    }

       
    #[Route('/advertisement/form/add', name: 'advertisement_add')]
    public function addAdvertisement(Request $request, EntityManagerInterface $em, AdvFormSecurity $isSecured): Response
    {

        $advertisement = new Advertisement;


        $actualUser = $this->getUser(); 

        $form = $this -> createForm(AdvertisementType::class, $advertisement);
        $form -> handleRequest($request);

        

        if($form->isSubmitted() && $form->isValid()){
            $datas = $form->getData();
            //vérification du formulaire enregistré
            $securedInputs = $isSecured->checkForm($datas);
            // si le formulaire respecte nos sécurités
            if($securedInputs){
                $region = $isSecured->getRegion($datas->getCity());

                $securedInputs->setRegion($region);
                $securedInputs->setDate(new \DateTime("now"));
                $securedInputs->setStatus(1);
                $securedInputs->setUser($actualUser);
                $em->persist($securedInputs);
                $em->flush();

                $this->addFlash('success', 'Votre annonce a bien été créée');

                return $this->redirectToRoute("app_advertisement");

            } else {


                $this->addFlash('danger', 'Données saisies non conformes !');

                return $this->redirectToRoute('advertisement_add');
            }
        }


        return $this->render('advertisement/add.html.twig', [
            'form' => $form -> createView(),
        ]);
    }


    #[Route('/advertisement/info/{id}', name: 'advertisement_info')]
    public function getAdvertisement(int $id, EntityManagerInterface $em, Request $request, AdvFormSecurity $isSecured)
    {

        $advertisement = $em->getRepository(Advertisement::class)->find($id);
        
        $advForm = $this->createForm(AdvertisementType::class, $advertisement);
        $advForm -> handleRequest($request);

        $render = $this->render('advertisement/advertisement_id.html.twig', [
            'advertisement' => $advertisement,
            'advForm' => $advForm->createView(),
        ]);


        if($advForm->isSubmitted() && $advForm->isValid()){
            $advEdit = $advForm -> getData();

            $securedAdvEdit = $isSecured->checkForm($advEdit);

            if($securedAdvEdit){
                $securedAdvEdit->setDate(new \DateTime("now"));
                $securedAdvEdit->setStatus(1);
                $securedAdvEdit->setUser($this->getUser());
                $em->persist($securedAdvEdit);
                $em->flush();

                $this->addFlash('success', 'Votre message a bien été envoyée');

                return $this->redirectToRoute('app_advertisement');

            } else {

 
                $this->addFlash('danger', 'Données saisies non conformes !');

                return $render;
            }
        }

        $msgAdvertisement = $request->get('messageContent');

        $actualUser = $this->getUser();

        if(isset($msgAdvertisement) && !empty($msgAdvertisement)){

            $recipient = $em->getRepository(User::class)->findOneBy(["id" => $advertisement->getUser()]);

            $securedMessageContent = htmlspecialchars($msgAdvertisement);
            $message = new Messages;
            $message->setContent($securedMessageContent);
            $message->setSender($actualUser);
            $message->setRecipient($recipient);
            $message->setCreatedAt(new DateTime());


            $em->persist($message);
            $em->flush();

            // Mailer à voir avec une adresse de l'hébergeur
            //$mailer->sendEmail($mail, $recipient);

            // logique à rajouter ici ?pour compléter et prévenir plusieurs cas
            
        
            $this->addFlash('success', 'Votre annonce a bien été créée');


            return $this->redirectToRoute('app_advertisement');
        }

        return $render;
    }

    #[Route('advertisement/delete/{id}', name: 'app_advDelete')]
    public function deleteAdv(int $id, EntityManagerInterface $em)
    {
        $advToDelete = $em->getRepository(Advertisement::class)->find($id);

        $em->remove($advToDelete);
        $em->flush();

        $this->addFlash('info', 'Votre annonce a bien été supprimé');


        return $this->redirectToRoute('app_advertisement'); 
    }



    // #[Route('/admin/advertisements', name: 'app_admin_advertisements')]
    // public function adminAdvertisements(EntityManagerInterface $em): Response
    // {
    //     $listAdvertisements = $em->getRepository(Advertisement::class)->findAll();

    //     return $this->render('home/adminAdvertisements.html.twig', [
    //         'advertisements'=> $listAdvertisements
    //     ]);
    // }


    // #[Route('admin/advertisement-delete-{id}', name: 'app_admin_deleteAdv')]
    // public function adminDeleteAdv(int $id, EntityManagerInterface $em)
    // {
    //     $advToDelete = $em->getRepository(Advertisement::class)->find($id);

    //     $em->remove($advToDelete);
    //     $em->flush();

    //     $this->addFlash('info', 'L\'annonce a bien été supprimé');

    //     return $this->redirectToRoute('app_admin_advertisements'); 
    // }
}



