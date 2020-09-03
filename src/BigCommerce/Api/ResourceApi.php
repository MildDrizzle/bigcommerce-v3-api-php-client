<?php

namespace BigCommerce\ApiV3\Api;

use BigCommerce\ApiV3\Client;
use BigCommerce\ApiV3\ResourceModels\ResourceModel;
use BigCommerce\ApiV3\ResponseModels\PaginatedResponse;
use BigCommerce\ApiV3\ResponseModels\SingleResourceResponse;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;

abstract class ResourceApi extends V3ApiBase
{
    use GetAllFromBigCommerce;

    abstract protected function singleResourceEndpoint(): string;
    abstract protected function multipleResourcesEndpoint(): string;
    abstract protected function resourceName(): string;

    protected function getResource(): ResponseInterface
    {
        return $this->getClient()->getRestClient()->get($this->singleResourceUrl());
    }

    protected function createResource(object $resource): ResponseInterface
    {
        return $this->getClient()->getRestClient()->post(
            $this->multipleResourceUrl(),
            [
                RequestOptions::JSON => $resource,
            ]
        );
    }

    protected function updateResource(object $resource): ResponseInterface
    {
        return $this->getClient()->getRestClient()->put(
            $this->singleResourceUrl(),
            [
                RequestOptions::JSON => $resource,
            ]
        );
    }

    public function delete(): ResponseInterface
    {
        return $this->getClient()->getRestClient()->delete($this->singleResourceUrl());
    }

    protected function singleResourceUrl(): string
    {
        if (is_null($this->getResourceId())) {
            throw new UnexpectedValueException("A {$this->resourceName()} id must be to be set");
        }

        return sprintf(
            $this->singleResourceEndpoint(),
            $this->getParentResourceId() ?? $this->getResourceId(),
            $this->getResourceId()
        );
    }

    protected function multipleResourceUrl(): string
    {
        return sprintf($this->multipleResourcesEndpoint(), $this->getParentResourceId());
    }

    abstract public function get(): SingleResourceResponse;
    abstract public function getAll(array $filters = [], int $page = 1, int $limit = 250): PaginatedResponse;
}
