<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 10/13/16
 * Time: 1:38 PM
 */

namespace AppBundle\Controller\Web;


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
   * @Route("/posts")
   */
  public function listAction() {
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('AppBundle:Post')->findAll();

    return $this->render('post/list.html.twig',
      ['posts' => $posts]
    );
  }

  /**
   * @Route("/posts/{post_id}", name="post_detail")
   */
  public function showAction($post_id = NULL) {
    $em = $this->getDoctrine()->getManager();
    $post = $em->getRepository('AppBundle:Post')->findOneBy(['id' => $post_id ]);

    if (!$post) {
      throw $this->createNotFoundException('No Post Found');
    }

    return $this->render('post/detail.html.twig', [
      'post' => $post
    ]);

  }

}