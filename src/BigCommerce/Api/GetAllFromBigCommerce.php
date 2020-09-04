<?php

namespace BigCommerce\ApiV3\Api;

use BigCommerce\ApiV3\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

trait GetAllFromBigCommerce
{
    abstract public function multipleResourceUrl(): string;
    abstract public function getClient(): Client;

    protected function getAllResources(array $filters = [], int $page = 1, int $limit = 250): ResponseInterface
    {
        return $this->getClient()->getRestClient()->get(
            $this->multipleResourceUrl(),
            [
                RequestOptions::QUERY => array_merge($filters, [
                    'page'  => $page,
                    'limit' => $limit,
                ])
            ]
        );
    }
}
