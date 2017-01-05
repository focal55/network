<?php
/**
 * Created by PhpStorm.
 * User: ybarra
 * Date: 1/5/17
 * Time: 10:36 AM
 */

namespace AppBundle\Api;


class ResponseFactory {
  public function createResponse(ApiProblem $apiProblem)
  {
    $data = $apiProblem->toArray();
    // making type a URL, to a temporarily fake page
    if ($data['type'] != 'about:blank') {
      $data['type'] = 'http://localhost:8000/docs/errors#'.$data['type'];
    }

    $response = new JsonResponse(
      $data,
      $apiProblem->getStatusCode()
    );
    $response->headers->set('Content-Type', 'application/problem+json');

    return $response;
  }
}