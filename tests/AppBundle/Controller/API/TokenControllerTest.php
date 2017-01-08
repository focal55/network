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
            'form_params' => [
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
          'form_params' => [
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
          'form_params' => [
            'email' => 'joe@foo.com',
            'fb_token' => 'EAACYSNVMJkcBAJRfED83K5ENpNDDYBscggP2nPxnLXIaK0hi101wh1TghAv9EsPUjQUF7364B9HSgDGZB9xWdyKXPHB4TVa2dMmoDZCydEZCuu1QZAPCrYmrPk2iLvPN6ZC4SZA6NPFStiU4eMDf3ow4IIJflO1z8tdXznxeENYQZDZD'
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
          'form_params' => [
            'email' => 'nouser@foo.com',
            'fb_token' => 'EAACYSNVMJkcBAJRfED83K5ENpNDDYBscggP2nPxnLXIaK0hi101wh1TghAv9EsPUjQUF7364B9HSgDGZB9xWdyKXPHB4TVa2dMmoDZCydEZCuu1QZAPCrYmrPk2iLvPN6ZC4SZA6NPFStiU4eMDf3ow4IIJflO1z8tdXznxeENYQZDZD'
          ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
          $response,
          'token'
        );
    }
}