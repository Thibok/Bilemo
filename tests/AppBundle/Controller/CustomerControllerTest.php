<?php

/**
 * CustomerController test
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * CustomerControllerTest
 */
class CustomerControllerTest extends WebTestCase
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
     * Test addAction
     * @access public
     * 
     * @return void
     */
    public function testAddAction()
    {
        $data['email'] = 'test@email.com';
        $data['first_name'] = 'Enzo';
        $data['last_name'] = 'Test';
        $data['city'] = 'Paris';
        $data['country'] = 'France';
        $data['address'] = '40 bd Raspail';

        $body = json_encode($data, true);
        $this->initializeBearerAuthorization('main');

        $this->client->request(
            'POST',
            '/customers',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $body
        );

        $response = $this->client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $authenticatedUser = $body['_embedded']['authenticated_user'];

        $description = 'Apple make the best phone !';

        $this->assertNotNull($body['id']);
        $this->assertSame('test@email.com', $body['email']);
        $this->assertSame('Enzo', $body['first_name']);
        $this->assertSame('Test', $body['last_name']);
        $this->assertSame('Paris', $body['city']);
        $this->assertEquals('France', $body['country']);
        $this->assertSame('40 bd Raspail', $body['address']);
        $this->assertNotNull($body['_links']['self']['href']);
        $this->assertNotNull($body['_links']['delete']['href']);

        $this->assertNotNull($authenticatedUser['id']);
        $this->assertSame('Bryan', $authenticatedUser['first_name']);
        $this->assertSame('Test', $authenticatedUser['last_name']);
        $this->assertNotNull($authenticatedUser['facebook_id']);
        $this->assertSame('ROLE_USER', $authenticatedUser['roles'][0]);
        $this->assertNotNull($authenticatedUser['access_token']);
    }

    /**
     * Test addAction with bad values
     * @access public
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $city
     * @param string $country
     * @param string $address
     * @param string $expectedErrors
     * @dataProvider addActionBadValues
     * 
     * @return void
     */
    public function testAddActionWithBadValues($email, $firstName, $lastName, $city, $country, $address, $expectedErrors)
    {
        $data['email'] = $email;
        $data['first_name'] = $firstName;
        $data['last_name'] = $lastName;
        $data['city'] = $city;
        $data['country'] = $country;
        $data['address'] = $address;

        $body = json_encode($data, true);
        $this->initializeBearerAuthorization('main');

        $this->client->request(
            'POST',
            '/customers',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $body
        );

        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $this->assertEquals(400, $body['code']);

        $nbErrors = mb_substr_count($body['message'], 'Field');

        $this->assertEquals($expectedErrors, $nbErrors);
    }

    /**
     * @access public
     * Bad values for addAction
     *
     * @return void
     */
    public function addActionBadValues()
    {
        return [
            [
                '',
                '',
                '',
                '',
                '',
                '',
                6
            ],
            [
                'e@fg.f',
                'l',
                't',
                '',
                'fr',
                'none',
                8
            ],
            [
                'dpcvmfyzpeodjfyvjcpslzitudbepbleocmdlfycpsurleydpcothfmqpzycjrleicjgp@yahoo.com',
                'averyveryveryveryveryveryveryveryverylongname',
                'averyveryveryveryveryveryveryveryverylongname',
                'averyveryveryveryveryveryveryveryverylongcity',
                'averyveryveryveryveryveryveryveryverylongcountry',
                'averyveryveryveryveryveryveryveryverylongaddress',
                6
            ],
            [
                'notgooodemail.com',
                '55455555',
                '55555555',
                '125863',
                'my_fav_country_156',
                'my_address_is_not_g00d!',
                6
            ],
            [
                'jeantest@yahoo.com',
                '55455555',
                '55555555',
                '125863',
                'my_fav_country_156',
                'my_address_is_not_g00d!',
                6
            ],
        ];
    }

    /**
     * Test deleteAction
     * @access public
     * 
     * @return void
     */
    public function testDeleteAction()
    {
        $this->initializeBearerAuthorization('secondary');

        $this->client->request('DELETE', '/customers/2');
        $response = $this->client->getResponse();

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEmpty($response->getContent());

        $this->client->request('DELETE', '/customers/2');
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
        $body = json_decode($response->getContent(), true);

        $this->assertEquals(404, $body['code']);
        $this->assertSame('This resource does not exist', $body['message']);
    }

    /**
     * Test to delete a customer with the not owner user
     * @access public
     * 
     * @return void
     */
    public function testDeleteActionWithBadUser()
    {
        $this->initializeBearerAuthorization('secondary');

        $this->client->request('DELETE', '/customers/1');
        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);

        $this->assertEquals(403, $body['code']);
        $this->assertSame('This resource is not accessible to you', $body['message']);
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

        if ($type == 'secondary') {
            $accessToken = 'Bearer ' .$this->client->getContainer()->getParameter('fb_test_secondary_access_token');
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