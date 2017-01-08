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

    public function testPUTCreateToken()
    {
        $this->createUser('weaverryan', 'test');

        $response = $this->client->post('/api/tokens', [
            'json' => [
                'email' => 'weaverryan@foo.com',
                'password' => 'test'
            ]
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
          'json' => [
            'email' => 'weaverryan@foo.com',
            'password' => 'test'
          ]
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testPOSTCreateTokenWithFBAuthOnExistingUser()
    {
        $this->createUser('joe', 'test');

        $response = $this->client->post('/api/tokens/fb', [
          'json' => [
            'email' => 'joe@foo.com',
            'fb_token' => 'EAACYSNVMJkcBAMtNFrfQc7ukM4N3oDQJRby2cRWx0ZBk3rgbIQb2l6egvzY0EIy6ZBTUPyFpU1yt9m2P6OlxQbfknrhZBGf9KKmTDAWThOQEkV2XjoaRKTTaek21CYQsVFAi7oJf7GzeLzVx4bbxzXZC7JgmhWuggbPCH6Xv5AZDZD'
          ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
          $response,
          'token'
        );
    }

    public function testPOSTCreateTokenWithFBAuthOnNonExistingUser()
    {
        $response = $this->client->post('/api/tokens/fb', [
          'json' => [
            'email' => 'nouser@foo.com',
            'fb_token' => 'EAACYSNVMJkcBAMtNFrfQc7ukM4N3oDQJRby2cRWx0ZBk3rgbIQb2l6egvzY0EIy6ZBTUPyFpU1yt9m2P6OlxQbfknrhZBGf9KKmTDAWThOQEkV2XjoaRKTTaek21CYQsVFAi7oJf7GzeLzVx4bbxzXZC7JgmhWuggbPCH6Xv5AZDZD'
          ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
          $response,
          'token'
        );
    }
}