<?php

/**
 * PhoneController test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Phone;
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
     * Test listAction
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

        $this->assertNotEmpty($data[0]['id']);
        $this->assertSame('Apple', $data[0]['brand']);
        $this->assertSame('800.00', $data[0]['price']);
        $this->assertSame($description, $data[0]['description']);
        $this->assertSame('IPhone XR', $data[0]['model']);
        $this->assertEquals(64, $data[0]['memory']);
        $this->assertSame('Black', $data[0]['color']);
        $this->assertNotEmpty($data[0]['_links']['self']['href']);

        $this->assertEquals(5, $meta['limit']);
        $this->assertEquals(5, $meta['current_items']);
        $this->assertEquals(10, $meta['total_items']);
        $this->assertEquals(1, $meta['page']);

        $this->assertNotEmpty($authenticatedUser['id']);
        $this->assertNotEmpty($authenticatedUser['first_name']);
        $this->assertNotEmpty($authenticatedUser['last_name']);
        $this->assertNotEmpty($authenticatedUser['facebook_id']);
        $this->assertSame('ROLE_USER', $authenticatedUser['roles'][0]);
        $this->assertNotEmpty($authenticatedUser['access_token']);
    }

    /**
     * Test viewAction
     * @access public
     * 
     * @return void
     */
    public function testViewAction()
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $phone = $manager->getRepository(Phone::class)->findOneByModel('IPhone XR');
        $url = '/phones/'.$phone->getId();

        $this->initializeBearerAuthorization('main');

        $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $authenticatedUser = $body['_embedded']['authenticated_user'];

        $description = 'Apple make the best phone !';

        $this->assertNotEmpty($body['id']);
        $this->assertSame('Apple', $body['brand']);
        $this->assertSame('800.00', $body['price']);
        $this->assertSame($description, $body['description']);
        $this->assertSame('IPhone XR', $body['model']);
        $this->assertEquals(64, $body['memory']);
        $this->assertSame('Black', $body['color']);
        $this->assertNotEmpty($body['_links']['self']['href']);

        $this->assertNotEmpty($authenticatedUser['id']);
        $this->assertNotEmpty($authenticatedUser['first_name']);
        $this->assertNotEmpty($authenticatedUser['last_name']);
        $this->assertNotEmpty($authenticatedUser['facebook_id']);
        $this->assertSame('ROLE_USER', $authenticatedUser['roles'][0]);
        $this->assertNotEmpty($authenticatedUser['access_token']);
    }

    /**
     * Test viewAction with unknow phone param
     * @access public
     * 
     * @return void
     */
    public function testViewActionWithUnknowPhone()
    {
        $this->initializeBearerAuthorization('main');
        $this->client->request('GET', '/phones/unknowPhone');

        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $this->assertEquals(404, $body['code']);
        $this->assertSame('This resource does not exist', $body['message']);
    }

    /**
     * Set header Authorization Bearer access token
     * @access private
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