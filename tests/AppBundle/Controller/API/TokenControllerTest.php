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
    public function testPOSTCreateToken()
    {
        $this->createUser('weaverryan', 'test');

        $response = $this->client->post('/api/tokens', [
            'auth' => ['weaverryan@foo.com', 'test']
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
            $response,
            'token'
        );
    }

    public function testPOSTInvalidCredentials()
    {
        $this->createUser('weaverryan', 'testasdsad');

        $response = $this->client->post('/api/tokens', [
            'auth' => ['weaverryan', 'test']
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }
}