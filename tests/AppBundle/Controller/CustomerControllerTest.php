<?php

/**
 * CustomerController test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Customer;
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

        $this->assertNotEmpty($body['id']);
        $this->assertSame('test@email.com', $body['email']);
        $this->assertSame('Enzo', $body['first_name']);
        $this->assertSame('Test', $body['last_name']);
        $this->assertSame('Paris', $body['city']);
        $this->assertEquals('France', $body['country']);
        $this->assertSame('40 bd Raspail', $body['address']);
        $this->assertNotEmpty($body['_links']['self']['href']);
        $this->assertNotEmpty($body['_links']['delete']['href']);

        $this->assertNotEmpty($authenticatedUser['id']);
        $this->assertNotEmpty($authenticatedUser['first_name']);
        $this->assertNotEmpty($authenticatedUser['last_name']);
        $this->assertNotEmpty($authenticatedUser['facebook_id']);
        $this->assertSame('ROLE_USER', $authenticatedUser['roles'][0]);
        $this->assertNotEmpty($authenticatedUser['access_token']);
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
     * @return array
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
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $customer = $manager->getRepository(Customer::class)->findOneByEmail('francoistest@orange.fr');
        $url = '/customers/'.$customer->getId();

        $this->initializeBearerAuthorization('secondary');

        $this->client->request('DELETE', $url);
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
     * Test listAction
     * @access public
     * 
     * @return void
     */
    public function testListAction()
    {
        $this->initializeBearerAuthorization('main');
        $this->client->request('GET', '/customers');

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $data = $body['data'];
        $meta = $body['meta'];
        $authenticatedUser = $body['_embedded']['authenticated_user'];

        $this->assertEquals(5, count($data));

        $this->assertNotEmpty($data[0]['id']);
        $this->assertSame('jeantest@yahoo.com', $data[0]['email']);
        $this->assertSame('Jean', $data[0]['first_name']);
        $this->assertSame('Test', $data[0]['last_name']);
        $this->assertSame('Bordeaux', $data[0]['city']);
        $this->assertEquals('France', $data[0]['country']);
        $this->assertSame('52 rue des mimosas', $data[0]['address']);
        $this->assertNotEmpty($data[0]['_links']['self']['href']);
        $this->assertNotEmpty($data[0]['_links']['delete']['href']);

        $this->assertEquals(5, $meta['limit']);
        $this->assertEquals(5, $meta['current_items']);
        $this->assertEquals(11, $meta['total_items']);
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
        $customer = $manager->getRepository(Customer::class)->findOneByEmail('jeantest@yahoo.com');
        $url = '/customers/'.$customer->getId();

        $this->initializeBearerAuthorization('main');

        $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);
        $authenticatedUser = $body['_embedded']['authenticated_user'];

        $this->assertNotEmpty($body['id']);
        $this->assertSame('jeantest@yahoo.com', $body['email']);
        $this->assertSame('Jean', $body['first_name']);
        $this->assertSame('Test', $body['last_name']);
        $this->assertSame('Bordeaux', $body['city']);
        $this->assertEquals('France', $body['country']);
        $this->assertSame('52 rue des mimosas', $body['address']);
        $this->assertNotEmpty($body['_links']['self']['href']);
        $this->assertNotEmpty($body['_links']['delete']['href']);

        $this->assertNotEmpty($authenticatedUser['id']);
        $this->assertNotEmpty($authenticatedUser['first_name']);
        $this->assertNotEmpty($authenticatedUser['last_name']);
        $this->assertNotEmpty($authenticatedUser['facebook_id']);
        $this->assertSame('ROLE_USER', $authenticatedUser['roles'][0]);
        $this->assertNotEmpty($authenticatedUser['access_token']);
    }

    /**
     * Test to access a ressource with not owner user
     * @access public
     * @param string $method
     * @dataProvider httpMethodValues
     * 
     * @return void
     */
    public function testToAccessARessourceWithNotOwnerUser($method)
    {
        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $customer = $manager->getRepository(Customer::class)->findOneByEmail('jeantest@yahoo.com');
        $url = '/customers/'.$customer->getId();

        $this->initializeBearerAuthorization('secondary');

        $this->client->request($method, $url);
        $response = $this->client->getResponse();

        $this->assertEquals(403, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);

        $this->assertEquals(403, $body['code']);
        $this->assertSame('This resource is not accessible to you', $body['message']);
    }

    /**
     * @access public
     * Method (GET,DELETE,etc...) for testToAccessARessourceWithNotOwnerUser
     *
     * @return array
     */
    public function httpMethodValues()
    {
        return [
            [
                'GET',
            ],
            [
                'DELETE',
            ],
        ];
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