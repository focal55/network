<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 1/4/17
 * Time: 1:19 PM
 */

namespace AppBundle\Controller\API;


use AppBundle\Controller\BaseController;
use Facebook\Facebook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends BaseController
{

    /**
     * @Route("/api/tokens/{op}")
     * @Method("POST")
     */
    public function newTokenAction(Request $request, $op)
    {
        $token = NULL;

        // Check if the user's email is in the database.
        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(['email' => $request->getUser()]);

        if (!$user) {
            throw $this->createNotFoundException('No User');
        }

        // If $op is fb, attempt to use the access token to access their profile.
        if ($op == 'fb' && isset($request['fb_token'])) {
            $fb = new Facebook([
                'app_id' => $this->container->getParameter('fb_app_id'),
                'app_secret' => $this->container->getParameter('fb_secret'),
            ]);
            $check_response = $fb->get('/me', $request['fb_token']);
            if ($check_response[])
        }
        // If $op is credentials, check password.
        elseif ($op == 'credentials') {
            $isValid = $this->get('security.password_encoder')
                ->isPasswordValid($user, $request->getPassword());
            if (!$isValid) {
                throw new BadCredentialsException();
            }
        }





        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        return new JsonResponse([
            'token' => $token
        ]);

    }
}