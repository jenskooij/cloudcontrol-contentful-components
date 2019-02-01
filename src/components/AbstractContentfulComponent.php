<?php
/**
 * Created by Jens on 23-12-2018.
 */

namespace components;


use CloudControl\Cms\components\CachableBaseComponent;
use CloudControl\Cms\services\ValuelistService;
use CloudControl\Cms\storage\Storage;
use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use RuntimeException;

abstract class AbstractContentfulComponent extends CachableBaseComponent
{
    const PARAM_ENTRIES = 'entries';
    const PARAM_ENTRY_ID = 'entryId';
    const PARAM_ENTRY = 'entry';

    private $spaceId;
    private $deliveryApiKey;
    private $client;

    /**
     * @param Storage $storage
     */
    public function run(Storage $storage)
    {
        parent::run($storage);

        $contentfulSettings = ValuelistService::get('contentful-settings');
        if ($contentfulSettings === null) {
            throw new RuntimeException('Couldnt find contentful settings. Please make a valuelist called "Contentful Settings".');
        }

        $this->deliveryApiKey = $contentfulSettings->get('deliveryApiKey');
        $this->spaceId = $contentfulSettings->get('spaceId');
        $this->client = new Client(
            $this->deliveryApiKey, // This is the access token for this space. Normally you get both ID and the token in the Contentful web app
            $this->spaceId // This is the space ID. A space is like a project folder in Contentful terms
        );

    }

    /**
     * @return string
     */
    public function getDeliveryApiKey()
    {
        return $this->deliveryApiKey;
    }

    /**
     * @return string
     */
    public function getSpaceId()
    {
        return $this->spaceId;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ContentfulQueryParameters $queryParameters
     * @return Query
     */
    protected function getQuery(ContentfulQueryParameters $queryParameters) {
        $query = new Query();
        $query->setContentType($queryParameters->getContentType());
        $query->setInclude($queryParameters->getInclude());
        if ($queryParameters->getOrderBy() != null) {
            $query->orderBy($queryParameters->getOrderBy(), $queryParameters->isOrderByReverse());
        }
        $query->setLimit($queryParameters->getLimit());
        $query->setSkip($queryParameters->getSkip());
        return $query;
    }
}