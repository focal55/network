<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 1/6/17
 * Time: 10:04 AM
 */

namespace AppBundle\Controller\Web;


use AppBundle\Controller\BaseController;
use Facebook\Facebook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class FacebookController extends BaseController
{

    /**
     * @Route("/fb", name="fbtest")
     */
    public function indexAction(Request $request)
    {
        $fb = new Facebook([
            'app_id' => $this->container->getParameter('fb_app_id'),
            'app_secret' => $this->container->getParameter('fb_secret'),
        ]);

        // Test token.
        $access_token = 'EAACYSNVMJkcBALmZC7dQEo3s50H1gWbls7BQacnRtqTVlQUWVY1cVdJ8lD0e0D99YcP6NE2IuTKd5SUTVgYGxfgIZCTu2bq0nIQfWMPTyaBX9kegLfNZBnIri5WpZAbWSy8nLQEZBFL4SqWzmCZC5zEdmlLfTllOCMyZBJ3ZAlu7zgZDZD';

        $response = $fb->get('/me', $access_token);

        dump($response);

        return $this->render('basic/basic.html.twig', [
            'body' => "Hello"
        ]);
    }
}