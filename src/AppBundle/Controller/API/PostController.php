<?php

namespace AppBundle\Controller\API;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class PostController extends BaseController
{
    /**
     * @Route("/api/posts")
     * @Method("GET")
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findAll();

        $response = $this->createApiResponse($posts, 200);

        return $response;
    }
}