<?php
/**
 * Created by Jens on 23-12-2018.
 */

namespace components;


use CloudControl\Cms\storage\Storage;
use Contentful\Delivery\Query;

class ContentfulEntriesByContentTypeComponent extends AbstractContentfulComponent
{
    const PARAM_ENTRIES_PARAM_NAME = 'entriesParameterName';

    public function run(Storage $storage)
    {
        parent::run($storage);
        $parameters = $this->getParameters();

        $entriesParamName = self::PARAM_ENTRIES;
        if (isset($parameters[self::PARAM_ENTRIES_PARAM_NAME])) {
            $entriesParamName = $parameters[self::PARAM_ENTRIES_PARAM_NAME];
        }

        if (isset($parameters[ContentfulQueryParameters::PARAM_CONTENT_TYPE])) {
            $contentfulQueryParameters = ContentfulQueryParameters::buildFromArray($parameters);
            $query = $this->getQuery($contentfulQueryParameters);
            $entries = $this->getClient()->getEntries($query);
            $this->parameters[$entriesParamName] = $entries;
        }
    }



}