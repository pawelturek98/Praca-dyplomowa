<?php

declare(strict_types=1);

namespace App\Resource\Address;

use Throwable;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CountryResource
{
    private const COUNTRIES_API_BASE_URL = 'https://restcountries.com/v3/';
    private const ALL_ENDPOINT = 'all';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getAllCountriesList(): array
    {
        $response = $this->client->request('GET', self::COUNTRIES_API_BASE_URL . self::ALL_ENDPOINT);

        $countries = [];
        try {
            foreach ($response->toArray() as $country) {
                if (isset($country['name']['nativeName'])) {
                    $nativeName = current($country['name']['nativeName']);
                } else {
                    $nativeName = $country['name'];
                }
                $countries[$nativeName['common']] = $country['cca2'];
            }
        } catch (
            Throwable $e
        ) {
            $this->logger->error($e);
            dump($e);
        }

        return $countries;
    }
}
