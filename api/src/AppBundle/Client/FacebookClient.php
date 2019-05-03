<?php

/**
 * Custom client (using GuzzleHttp\Client) requesting Facebook for infos
 */

namespace AppBundle\Client;

use GuzzleHttp\Client;

/**
 * FacebookClient
 */
class FacebookClient
{
    /**
     * @var Client
     * @access private
     */
    private $client;

    /**
     * Constructor
     * @access public
     * @param Client $client
     * 
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Request Facebook for an user
     *
     * @param array $fields
     * @param string $accessToken
     * @return Response
     */
    public function requestFacebookForUser(array $fields, $accessToken)
    {
        $url = 'https://graph.facebook.com/me?access_token=' .$accessToken. '&fields=';
        $fieldsLength = count($fields);
        
        for ($index = 0; $index < $fieldsLength; $index++) { 
            $lastIndex = $fieldsLength - $index;
            if ($lastIndex == 1) {
                $url .= $fields[$index];
            } else {
                $url .= $fields[$index]. ',';
            }
        }

        return $response = $this->client->get($url);
    }
}