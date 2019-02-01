<?php
/**
 * Custom Component
 */

namespace components;


use CloudControl\Cms\components\BaseComponent;
use CloudControl\Cms\storage\Storage;

class ContentfulEntryByIdComponent extends AbstractContentfulComponent
{
    const PARAM_ENTRY_PARAM_NAME = 'entryParameterName';

    /**
     * @param Storage $storage
     * @return void
     */
    public function run(Storage $storage)
    {
        parent::run($storage);

        $parameters = $this->getParameters();

        $entryParamName = self::PARAM_ENTRY;
        if (isset($parameters[self::PARAM_ENTRY_PARAM_NAME])) {
            $entryParamName = $parameters[self::PARAM_ENTRY_PARAM_NAME];
        }

        if (isset($parameters[self::PARAM_ENTRY_ID])) {
            $entryId = $parameters[self::PARAM_ENTRY_ID];
            $entry = $this->getClient()->getEntry($entryId);
            $this->parameters[$entryParamName] = $entry;
        }
    }
}