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
     * @var string
     * @access private
     */
    private $secretKey;

    /**
     * @var string
     * @access private
     */
    private $env;

    /**
     * Constructor
     * @access public
     * @param Client $client
     * @param string $secretKey
     * @param string $env
     * 
     * @return void
     */
    public function __construct(Client $client, $secretKey, $env)
    {
        $this->client = $client;
        $this->secretKey = $secretKey;
        $this->env = $env;
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
        $url = 'https://graph.facebook.com/me?access_token=' .$accessToken;

        if ($this->env != 'test') {
            $secretProof = hash_hmac('sha256', $accessToken, $this->secretKey);
            $url .= '&appsecret_proof=' .$secretProof;
        }

        $url .= '&fields=';
        $fieldsLength = count($fields);
        
        for ($index = 0; $index < $fieldsLength; $index++) { 
            $lastIndex = $fieldsLength - $index;
            if ($lastIndex == 1) {
                $url .= $fields[$index];
                break;
            }

            $url .= $fields[$index]. ',';     
        }

        return $response = $this->client->get($url);
    }
}