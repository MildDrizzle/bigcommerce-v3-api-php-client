<?php

namespace BigCommerce\ApiV3\Api\Catalog\Brands;

use BigCommerce\ApiV3\Api\Generic\ResourceApi;
use BigCommerce\ApiV3\ResourceModels\Catalog\Brand\BrandMetafield;
use BigCommerce\ApiV3\ResponseModels\Brand\BrandMetafieldResponse;
use BigCommerce\ApiV3\ResponseModels\Brand\BrandMetafieldsResponse;

class BrandMetafieldsApi extends ResourceApi
{
    private const RESOURCE_NAME = 'metafields';
    private const METAFIELDS_ENDPOINT = 'catalog/brands/%d/metafields';
    private const METAFIELD_ENDPOINT = 'catalog/brands/%d/metafields/%d';

    protected function singleResourceEndpoint(): string
    {
        return self::METAFIELD_ENDPOINT;
    }

    protected function multipleResourcesEndpoint(): string
    {
        return self::METAFIELDS_ENDPOINT;
    }

    protected function resourceName(): string
    {
        return self::RESOURCE_NAME;
    }

    public function get(): BrandMetafieldResponse
    {
        return new BrandMetafieldResponse($this->getResource());
    }

    public function getAll(array $filters = [], int $page = 1, int $limit = 250): BrandMetafieldsResponse
    {
        return new BrandMetafieldsResponse($this->getAllResources($filters, $page, $limit));
    }

    public function create(BrandMetafield $brandMetafield): BrandMetafieldResponse
    {
        $brandMetafield->resource_id = $this->getParentResourceId() ?? 0;
        return new BrandMetafieldResponse($this->createResource($brandMetafield));
    }

    public function update(BrandMetafield $brandMetafield): BrandMetafieldResponse
    {
        return new BrandMetafieldResponse($this->updateResource($brandMetafield));
    }
}
