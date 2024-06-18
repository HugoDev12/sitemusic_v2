<?php

namespace App\Security;

use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Cast\Bool_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;

class AccessDeniedHandler extends AbstractController implements AccessDeniedHandlerInterface
{
    // is called when 403 error appears (access denied by access_control in security.yaml file)
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        // ...
        // $request->getSession()->get(SecurityRequestAttributes::LAST_ID) permet de récupérer l'ID de l'utilisateur connecté en session
        // $request->attributes->get("id") permet de récupérer le paramètre 'id' en url
        // dd($request, $request->getSession()->get(SecurityRequestAttributes::LAST_ID), intval($request->attributes->get("id")));


        return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
    }
  
}