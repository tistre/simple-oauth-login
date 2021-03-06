<?php

namespace Tistre\SimpleOAuthLogin;


use League\OAuth2\Client\Token\AccessToken;

class MicrosoftService extends Service
{
    const SERVICE = Login::SERVICE_MICROSOFT;


    /**
     * @return \League\OAuth2\Client\Provider\GenericProvider
     */
    public function getProvider()
    {
        if (!$this->provider) {
            $this->provider = new \League\OAuth2\Client\Provider\GenericProvider($this->config->getProviderParams());
        }

        return $this->provider;
    }


    /**
     * @param AccessToken $accessToken
     * @return array
     */
    public function getUserDetails(AccessToken $accessToken)
    {
        $result = [
            'name' => '',
            'mail' => '',
            'image' => '',
            'url' => ''
        ];

        // The id token is a JWT token that contains information about the user
        // It's a base64 coded string that has a header, payload and signature
        $idToken = $accessToken->getValues()['id_token'];

        $decodedAccessTokenPayload = base64_decode(explode('.', $idToken)[1]);

        $jsonAccessTokenPayload = json_decode($decodedAccessTokenPayload, true);

        if (isset($jsonAccessTokenPayload['name'])) {
            $result['name'] = $jsonAccessTokenPayload['name'];
        }

        // We need a second HTTP call to fetch the e-mail address

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://graph.microsoft.com/v1.0/me/', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken->getToken()
            ]
        ]);

        // TODO: Add error handling, throw an exception if e-mail fetch fails

        if ($response->getStatusCode() === 200) {
            $profileJson = $response->getBody()->getContents();
            $profile = json_decode($profileJson, true);
            
            if (isset($profile['mail'])) {
                $result['mail'] = $profile['mail'];
            }
            
            if (isset($profile['displayName'])) {
                $result['name'] = $profile['displayName'];
            }
        }

        return $result;
    }


    /**
     * @param AccessToken $accessToken
     * @return array
     */
    public function getUserGroups(AccessToken $accessToken)
    {
        $groups = [];
    
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://graph.microsoft.com/v1.0/me/memberOf', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken->getToken()
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            $profileJson = $response->getBody()->getContents();
            $profile = json_decode($profileJson, true);

            if (is_array($profile['value'])) {
                foreach ($profile['value'] as $directoryObject) {
                    $groups[] = [
                        'name' => $directoryObject['mailNickname'],
                        'displayName' => $directoryObject['displayName']
                    ];
                }
            }
        }
        
        return $groups;
    }


    /**
     * @return string
     */
    public function getLoginLinkText()
    {
        return 'Sign in with Microsoft';
    }
}
