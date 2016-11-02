<?php

namespace AppBundle\Controller\API;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends Controller
{
    /**
     * @Route("/api/tokens")
     * @Method("POST")
     */
    public function newTokenAction(Request $request)
    {
        $user = $this->getDoctrine()
          ->getRepository('UserBundle:User')
          ->findOneBy(['email' => $request->getUser()]);

        if (!$user) {
            throw $this->createNotFoundException('No User');
        }

        $isValid = $this->get('security.password_encoder')->isPasswordValid($user, $request->getPassword());

        if (!$isValid) {
            //throw new BadCredentialsException();
            throw $this->createNotFoundException($request->getPassword());
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
          ->encode(['username' => $user->getUsername(), 'exp' => time() + 3600]);

        return new JsonResponse([
          'token' => $token
        ]);
    }
}
