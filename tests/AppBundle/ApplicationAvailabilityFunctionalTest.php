<?php

/**
 * Global application tests
 */

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * ApplicationAvailabilityFunctionalTest
 */
class ApplicationAvailabilityFunctionalTest extends WebTestCase
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
     * Test if all url return a success response
     * @access public
     * @param string $url
     * @dataProvider urlProvider
     * 
     * @return void
     */
    public function testResponseSuccessful($method, $url)
    {
        $this->initializeBearerAuthorization('main');
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Url values
     * @access public
     *
     * @return array
     */
    public function urlProvider()
    {
        return array(
            array(
                'GET',
                '/phones'
            )
        );
    }

    /**
     * Test user can't access a ressource without header Bearer Authorization
     * @access public
     * @param string $url
     * @dataProvider urlProvider
     * 
     * @return void
     */
    public function testUserCantAccessResourceWithoutBearer($method, $url)
    {
        $this->client->request($method, $url);
        $response = $this->client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $message = 'Authentication error: You must be logged to access this page !';

        $this->assertEquals(401, $body['code']);
        $this->assertSame($message, $body['message']);
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