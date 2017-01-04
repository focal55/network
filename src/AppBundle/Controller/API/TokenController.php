<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 1/4/17
 * Time: 1:19 PM
 */

namespace AppBundle\Controller\API;


use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends BaseController
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

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $request->getPassword());

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        return new JsonResponse([
            'token' => $token
        ]);

    }
}