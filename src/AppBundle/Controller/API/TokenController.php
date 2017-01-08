<?php

namespace AppBundle\Controller\API;

use AppBundle\Api\ApiProblem;
use AppBundle\Api\ApiProblemException;
use AppBundle\Controller\BaseController;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use UserBundle\Entity\User;

class TokenController extends BaseController
{

    /**
     * @Route("/api/tokens/{op}")
     * @Method("POST")
     */
    public function newTokenAction(Request $request, $op = 'credentials')
    {

        $create_new_user = FALSE;

        // Check if the user's email is in the database.
        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(['email' => $request->get('email')]);

        // If $op is fb, attempt to use the access token to access their profile.
        if ($op == 'fb') {
            if ($request->get('fb_token')) {
                $fb = new Facebook([
                    'app_id' => $this->container->getParameter('fb_app_id'),
                    'app_secret' => $this->container->getParameter('fb_secret'),
                ]);

                try {
                    $response = $fb->get('/me?fields=email,name', $request->get('fb_token'));
                    // FB User Found, if no user in db, create it.
                    if (!$user) {
                        $fb_user = $response->getGraphUser();
                        $user = new User();
                        $user->setEmail($fb_user['email']);
                        $user->setCreated(time());
                        $user->setUpdated(time());
                        $user->setPlainPassword($this->generatePassword());
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($user);
                        $em->flush();
                    }

                } catch(FacebookResponseException $e) {
                    $apiProblem = new ApiProblem(400, ApiProblem::TYPE_VALIDATION_ERROR);
                    $apiProblem->set('details', $e->getMessage());
                    return $this->get('api.response_factory')->createResponse($apiProblem);

                } catch(FacebookSDKException $e) {
                    $apiProblem = new ApiProblem(400, ApiProblem::TYPE_VALIDATION_ERROR);
                    $apiProblem->set('details', $e->getMessage());
                    return $this->get('api.response_factory')->createResponse($apiProblem);
                }
            }
            else {
                throw new BadCredentialsException();
            }
        }

        // If $op is credentials, check password.
        elseif ($op == 'credentials' && $user) {
            $isValid = $this->get('security.password_encoder')
                ->isPasswordValid($user, $request->get('password'));
            if (!$isValid) {
                throw new BadCredentialsException();
            }
        }
        elseif (!$user) {
            throw new BadCredentialsException();
        }

        // Generate JWT.
        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        return new JsonResponse([
            'token' => $token,
            'create_new_user' => $create_new_user
        ]);
    }

    private function generatePassword($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}