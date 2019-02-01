<?php
/**
 * Created by Jens on 31-1-2019.
 */

namespace components;


use CloudControl\Cms\storage\Storage;
use getcloudcontrol\cloudcontrolContentfulComponents\ContentfulQueryParameters;

class ContentfulEntryBySlugComponent extends AbstractContentfulComponent
{
    public function run(Storage $storage)
    {
        parent::run($storage);
        $relativeSlug = $this->stipTrailingSlash(current($this->matchedSitemapItem->matches[1]));

        $parameters = $this->parameters;
        $query = $this->getQuery(ContentfulQueryParameters::buildFromArray($parameters));
        $query->where('fields.slug', $relativeSlug);
        $entries = $this->getClient()->getEntries($query);

        if (count($entries) === 0) {
            header("HTTP/1.0 404 Not Found");
            $this->template = '404';
        } else {
            $page_entry = current($entries->getItems());
            $this->parameters['page_entry'] = $page_entry;
        }
    }

    private function stipTrailingSlash($string)
    {
        if (substr($string, -1) === '/') {
            return substr($string, 0, -1);
        }
        return $string;
    }

}