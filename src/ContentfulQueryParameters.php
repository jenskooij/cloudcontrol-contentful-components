<?php
/**
 * Created by Jens on 23-12-2018.
 */

namespace getcloudcontrol\cloudcontrolContentfulComponents;


class ContentfulQueryParameters
{
    const PARAM_CONTENT_TYPE = 'contentType';
    const PARAM_INCLUDE = 'include';
    const PARAM_ORDER_BY = 'orderBy';
    const PARAM_ORDER_BY_REVERSE = 'orderByReverse';
    const PARAM_LIMIT = 'limit';
    const PARAM_SKIP = 'skip';

    protected $contentType;
    protected $include = null;
    protected $orderBy;
    protected $orderByReverse = false;
    protected $limit = null;
    protected $skip = null;

    /**
     * ContentfulQueryParameters constructor.
     * @param string $contentType
     * @param int|null $include
     * @param string|null $orderBy
     * @param bool $orderByReverse
     * @param int|null $limit
     * @param int|null $skip
     */
    public function __construct($contentType, $include = null, $orderBy = null, $orderByReverse= false, $limit = null, $skip = null)
    {
        $this->contentType = $contentType;
        $this->include = $include;
        $this->orderBy = $orderBy;
        $this->orderByReverse = $orderByReverse;
        $this->limit = $limit;
        $this->skip = $skip;
    }

    public static function buildFromArray($array) {
        $contentType =isset($array[self::PARAM_CONTENT_TYPE]) ? $array[self::PARAM_CONTENT_TYPE] : null;
        $include = isset($array[self::PARAM_INCLUDE]) ? $array[self::PARAM_INCLUDE] : null;
        $orderBy = isset($array[self::PARAM_ORDER_BY]) ? $array[self::PARAM_ORDER_BY] : null;
        $orderByReverse = isset($array[self::PARAM_ORDER_BY_REVERSE]) ? $bool = filter_var($array[self::PARAM_ORDER_BY_REVERSE], FILTER_VALIDATE_BOOLEAN) : false;
        $limit = isset($array[self::PARAM_LIMIT]) ? $array[self::PARAM_LIMIT] : null;
        $skip = isset($array[self::PARAM_SKIP]) ? $array[self::PARAM_SKIP] : null;

        return new ContentfulQueryParameters($contentType, $include, $orderBy, $orderByReverse, $limit, $skip);
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return int|null
     */
    public function getInclude()
    {
        return $this->include;
    }

    /**
     * @return string|null
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @return bool
     */
    public function isOrderByReverse()
    {
        return $this->orderByReverse;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getSkip()
    {
        return $this->skip;
    }


}