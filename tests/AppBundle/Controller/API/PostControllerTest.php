<?php

namespace tests\AppBundle\Controller\API;


use AppBundle\Tests\ApiTestCase;

class PostControllerTest extends ApiTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->createUser('joe');
    }

    public function testGETPosts()
    {
        for ($i=1;$i<7;$i++) {
            $this->createPost('Post #' . $i, "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec augue et orci maximus cursus. Nullam neque nisi, ultricies eu volutpat in, consequat a lacus. Mauris sit amet suscipit nisi, et volutpat ante. Nulla sit amet dui eleifend, gravida nulla id, rhoncus leo. Nunc ut leo posuere, posuere lacus quis, malesuada lectus.");
        }

        $response = $this->client->get('/api/posts', ['headers' => $this->getAuthorizedHeaders('joe@foo.com')]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertiesExist($response, ['[id]', '[uid]', '[title]', '[body]', '[created]', '[updated]']);
    }
}