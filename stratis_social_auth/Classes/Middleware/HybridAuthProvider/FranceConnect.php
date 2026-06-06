<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Middleware\HybridAuthProvider;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Hybridauth\Adapter\OAuth2;
use Hybridauth\Data\Collection;
use Hybridauth\Exception\Exception;
use Hybridauth\Exception\HttpClientFailureException;
use Hybridauth\Exception\HttpRequestFailedException;
use Hybridauth\Exception\InvalidAccessTokenException;
use Hybridauth\HttpClient;
use Hybridauth\User\Profile;
use Stratis\StratisSocialAuth\Utility\StringUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Http\RedirectResponse;

/**
 * Class FranceConnect
 * @package Stratis\StratisSocialAuth\Middleware\HybridAuthProvider
 */
class FranceConnect extends OAuth2
{
    /**
     * Adapter initializer
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->AuthorizeUrlParameters = [
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->callback,
            'scope' => $this->scope,
            'acr_values' => $this->config->get('acr_values'),
        ];

        $this->tokenRefreshParameters = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->callback,
            'code' => $this->getStoredData('code'),
        ];

        // Provider api end-points
        $this->apiBaseUrl = $this->config->get('openid_identifier');
        $this->authorizeUrl = $this->config->get('openid_identifier') . "/authorize";
        $this->accessTokenUrl = $this->config->get('openid_identifier') . "/token";
    }

    /**
     * Initiate the authorization protocol
     *
     * Build Authorization URL for Authorization Request and redirect the user-agent to the
     * Authorization Server.
     */
    protected function authenticateBegin(): void
    {
        $authUrl = $this->getAuthorizeUrl();

        $this->logger->debug(sprintf('%s::authenticateBegin(), redirecting user to:', get_class($this)), [$authUrl]);

        HttpClient\Util::redirect($authUrl);
    }

    /**
     * @return Profile
     * @throws HttpClientFailureException
     * @throws HttpRequestFailedException
     * @throws InvalidAccessTokenException
     */
    public function getUserProfile(): Profile
    {
        // get access token
        $accessToken = $this->getAccessToken();

        if ($this->decodeJwtToken($accessToken['id_token']) === null) {
            throw new InvalidAccessTokenException('Invalid id_token');
        }

        $userProfile = new Profile();

        // get user profile
        try {
            $userInfo = $this->getUserInfo($accessToken['access_token']);
            $data = new Collection($userInfo);

            $userProfile->identifier = $data->get('sub');
            $userProfile->firstName = $data->get('given_name');
            $userProfile->lastName = $data->get('family_name');
            $userProfile->displayName = $userProfile->lastName;

            $userProfile->gender = $data->get('gender') ?: "";
            $userProfile->email = $data->get('email');

            $birthday = $data->get('birthdate');

            if ($birthday) {
                [$birthday_year, $birthday_month, $birthday_day] = explode('-', $birthday);

                $userProfile->birthDay = (int)$birthday_day;
                $userProfile->birthMonth = (int)$birthday_month;
                $userProfile->birthYear = (int)$birthday_year;
            }
        } catch (\Throwable $e) {
            throw new HttpClientFailureException($e->getMessage(), $e->getCode(), $e);
        }

        return $userProfile;
    }

    /**
     * Get user info from France Connect
     *
     * @param string $accessToken
     * @return object|null
     */
    protected function getUserInfo(string $accessToken): object|null
    {
        $client = new Client([
            'base_uri' => $this->apiBaseUrl . '/',
            'verify' => false,
        ]);
        $response = $client->get('userinfo', ['headers' => ['Authorization' => 'Bearer ' . $accessToken]]);
        $content = $response->getBody()->getContents();

        return $this->decodeJwtToken($content);
    }

    protected function decodeJwtToken(string $idToken): object|null
    {
        $jwksJson = file_get_contents($this->apiBaseUrl . '/jwks');
        $jwks = json_decode($jwksJson, true);

        try {
            $keys = JWK::parseKeySet($jwks);
            $decoded = JWT::decode($idToken, $keys);
        } catch (\Throwable $e) {
            throw new InvalidAccessTokenException($e->getMessage(), $e->getCode(), $e);
        }

        return $decoded;
    }

    /**
     * @param array $parameters
     * @return string
     */
    protected function getAuthorizeUrl($parameters = []): string
    {
        $this->AuthorizeUrlParameters = !empty($parameters)
            ? $parameters
            : array_replace(
                (array) $this->AuthorizeUrlParameters,
                (array) $this->config->get('authorize_url_parameters')
            );

        if ($this->supportRequestState) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($this->AuthorizeUrlParameters['state'])) {
                $this->AuthorizeUrlParameters['state'] = 'HA-' . str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
            }

            $this->storeData('authorization_state', $this->AuthorizeUrlParameters['state']);
        }

        $this->AuthorizeUrlParameters['nonce'] = StringUtility::getRandomString();

        return $this->authorizeUrl . '?' . http_build_query($this->AuthorizeUrlParameters, '', '&');
    }

    /**
     * Correct logout from
     */
    public function disconnect(): void
    {
        $providerType = strtolower($this->providerId);
        $idToken = $this->storage->get($providerType . '.id_token');

        $parameters = http_build_query(
            [
                'id_token_hint' => $idToken,
                'state' => StringUtility::getRandomString(),
                'post_logout_redirect_uri' => $this->callback . '&logintype=logout',
            ]
        );

        $this->storage->clear();

        $url = $this->apiBaseUrl . '/session/end?' . $parameters;
        header("Location: " . $url);

        $response = new RedirectResponse($url);
        throw new PropagateResponseException($response, 1729253746);
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function authenticate(): ?bool
    {
        $code = filter_input(INPUT_GET, 'code');
        if ($code) {
            $this->storeData('code', $code);
        }

        return parent::authenticate();
    }

    public function getAccessToken(): array
    {
        $tokenNames = [
            'access_token',
            'id_token',
            'access_token_secret',
            'token_type',
            'refresh_token',
            'expires_in',
            'expires_at',
        ];

        $tokens = [];

        foreach ($tokenNames as $name) {
            if ($this->getStoredData($name)) {
                $tokens[$name] = $this->getStoredData($name);
            }
        }

        return $tokens;
    }

    protected function validateAccessTokenExchange($response): Collection
    {
        $collection = parent::validateAccessTokenExchange($response);
        $this->storeData('id_token', $collection->get('id_token'));

        return $collection;
    }
}
