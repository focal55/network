<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 10/13/16
 * Time: 1:38 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller  {

  /**
   * @Route("/posts/new")
   */
  public function newAction() {

    $post = new Post();
    $post->setUid(1);
    $post->setTitle('Post Attempt ' . rand(1, 100));
    $post->setBody('Hello World');
    $post->setCreated(time());
    $post->setUpdated(time());

    $em = $this->getDoctrine()->getManager();
    $em->persist($post);
    $em->flush();

    return new Response('Post Created');
  }

  /**
   * @Route("/posts/{post_id}")
   */
  public function showAction($post_id = NULL) {

    if ($post_id) {
      return $this->render('post/detail.html.twig', [
        'post_id' => $post_id
      ]);
    }
    else {
      return $this->render('post/list.html.twig', [
        'post_id' => $post_id
      ]);
    }

  }

}