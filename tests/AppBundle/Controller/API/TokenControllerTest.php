<?php
/**
 * Created by PhpStorm.
 * User: focal55
 * Date: 10/26/16
 * Time: 10:44 PM
 */

namespace Tests\AppBundle\Controller\API;


use AppBundle\Tests\ApiTestCase;

class TokenControllerTest extends ApiTestCase
{
    public function testRequiresAuthentication()
    {
        $response = $this->client->post('/api/programmers', [
          'body' => '[]'
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testPOSTCreateToken()
    {
        $this->createUser('weaverryan', 'I<3Pizza');

        // Post user/pass with Guzzle.
        $response = $this->client->post('/api/tokens', [
          'auth' => ['weaverryan@foo.com', 'I<3Pizza']
        ]);

        // Asset we get a successful response.
        $this->assertEquals(200, $response->getStatusCode());

        // Asset the response contains a 'token' property.
        $this->asserter()->assertResponsePropertyExists(
          $response,
          'token'
        );
    }
}