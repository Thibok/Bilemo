<?php

/**
 * ApplicationAvailabity FunctionalTest
 */

namespace Tests\AppBundle;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
     * Test if all page with no required authentication is up
     * @access public
     * @param string $url
     * @dataProvider urlProvider
     * 
     * @return void
     */
    public function testPageIsSuccessful($url)
    {
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Url values for testPageIsSuccessful
     * @access public
     *
     * @return array
     */
    public function urlProvider()
    {
        return array(
            array('/'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}