<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Middleware\HybridAuthProvider;

use Hybridauth\Adapter\OAuth2;
use Hybridauth\Data\Collection;
use Hybridauth\Exception\HttpClientFailureException;
use Hybridauth\Exception\HttpRequestFailedException;
use Hybridauth\Exception\InvalidAccessTokenException;
use Hybridauth\User\Profile;
use Stratis\StratisSocialAuth\Utility\StringUtility;

/**
 * Class Publik
 * @package Stratis\StratisSocialAuth\Middleware\HybridAuthProvider
 */
class Publik extends OAuth2
{
    /**
     * Adapter initializer
     */
    public function initialize(): void
    {
        parent::initialize();

        // Provider api end-points
        $this->apiBaseUrl = $this->config->get('openid_identifier');
        $this->authorizeUrl = $this->config->get('openid_identifier') . "/authorize/";
        $this->accessTokenUrl = $this->config->get('openid_identifier') . "/token/";
    }

    /**
     * @return Profile
     * @throws HttpClientFailureException
     * @throws HttpRequestFailedException
     * @throws InvalidAccessTokenException
     */
    public function getUserProfile(): Profile
    {
        // get user profile
        $response = $this->apiRequest('user_info', 'GET');
        $data = new Collection($response);

        $userProfile = new Profile();

        $userProfile->identifier = $data->get('sub');
        $userProfile->firstName = $data->get('given_name');
        $userProfile->lastName = $data->get('family_name');
        $userProfile->email = $data->get('email');
        $customDisplayName = $userProfile->firstName . ' ' . $userProfile->lastName;
        $userProfile->displayName = $data->get('preferred_username') ?: $customDisplayName;

        return $userProfile;
    }

    /**
     * Correct logout from
     */
    public function disconnect(): void
    {
        $parameters = http_build_query(
            [
                'id_token_hint' => $this->getAccessToken()['access_token'],
                'state' => StringUtility::getRandomString(),
            ]
        );
        $url = $this->apiBaseUrl . '/logout?' . $parameters;
        header("Location: " . $url);
    }
}
