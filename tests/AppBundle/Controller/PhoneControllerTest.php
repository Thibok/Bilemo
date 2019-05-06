<?php

/**
 * PhoneController test
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * PhoneControllerTest
 */
class PhoneControllerTest extends WebTestCase
{
    /**
     * @var Client
     * @access private
     */
    private $client;
    
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * Test list action PhoneController
     * @access public
     * 
     * @return void
     */
    public function testListAction()
    {
        $this->initializeBearerAuthorization('main');
        $this->client->request('GET', '/phones');

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $data = $body['data'];
        $meta = $body['meta'];
        $authenticatedUser = $body['_embedded']['authenticated_user'];

        $this->assertEquals(5, count($data));

        $description = 'Apple make the best phone !';

        $this->assertNotNull($data[0]['id']);
        $this->assertSame('Apple', $data[0]['brand']);
        $this->assertSame('800.00', $data[0]['price']);
        $this->assertSame($description, $data[0]['description']);
        $this->assertSame('IPhone XR', $data[0]['model']);
        $this->assertEquals(64, $data[0]['memory']);
        $this->assertSame('Black', $data[0]['color']);
        $this->assertNotNull($data[0]['_links']['self']['href']);

        $this->assertEquals(5, $meta['limit']);
        $this->assertEquals(5, $meta['current_items']);
        $this->assertEquals(10, $meta['total_items']);
        $this->assertEquals(1, $meta['page']);

        $this->assertNotNull($authenticatedUser['id']);
        $this->assertSame('Bryan', $authenticatedUser['first_name']);
        $this->assertSame('Test', $authenticatedUser['last_name']);
        $this->assertNotNull($authenticatedUser['facebook_id']);
        $this->assertSame('ROLE_USER', $authenticatedUser['roles'][0]);
        $this->assertNotNull($authenticatedUser['access_token']);
    }

    /**
     * Set header Authorization Bearer access token
     * @access public
     * @param string $type
     * 
     * @return void
     */
    private function initializeBearerAuthorization($type)
    {
        if ($type == 'main') {
            $accessToken = 'Bearer ' .$this->client->getContainer()->getParameter('fb_test_main_access_token');
        }

        $this->client->setServerParameter('HTTP_Authorization', $accessToken);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}