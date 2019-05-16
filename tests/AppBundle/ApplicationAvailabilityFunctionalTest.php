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
            ),
            array(
                'GET',
                '/phones/1'
            ),
            array(
                'POST',
                '/customers'
            ),
            array(
                'GET',
                '/customers'
            ),
            array(
                'DELETE',
                '/customers/1'
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
        $message = 'Authentication error: You must be logged to access this resource !';

        $this->assertEquals(401, $body['code']);
        $this->assertSame($message, $body['message']);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}