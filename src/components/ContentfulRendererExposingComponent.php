<?php
/**
 * Created by Jens on 1-2-2019.
 */

namespace components;


use CloudControl\Cms\components\BaseComponent;
use CloudControl\Cms\storage\Storage;
use Contentful\RichText\Renderer;
use getcloudcontrol\cloudcontrolContentfulComponents\renderer\HyperlinkRenderer;

class ContentfulRendererExposingComponent extends BaseComponent
{
    const PARAM_HYPERLINK_FIELD = 'hyperlinkField';
    const PARAM_CONTENT_TYPE = 'contentType';
    const PARAM_URL_PREFIX = 'urlPrefix';
    const PARAM_CONTENTFUL_RENDERER = 'contentfulRenderer';

    protected $hyperlinkField = array('slug');
    protected $contentType = array('page');
    protected $urlPrefix = array();

    /**
     * @var Renderer
     */
    protected $contentfulRenderer;
    /**
     * @var array:NodeRendererInterface
     */
    protected $renderers = array();

    /**
     * Create the default HyperlinkRenderer with the settings as passed by
     * the sitemap / application component definition parameters
     *
     * @param Storage $storage
     */
    public function run(Storage $storage)
    {
        parent::run($storage);

        $this->handleParameters();

        $this->contentfulRenderer = new Renderer();

        foreach ($this->contentType as $i => $contentType) {
            $hyperlinkRenderer = new HyperlinkRenderer(isset($this->hyperlinkField[$i]) ? $this->hyperlinkField[$i] : 'slug', $contentType, isset($this->urlPrefix[$i]) ? $this->urlPrefix[$i] : null);
            $this->addNodeRenderer($hyperlinkRenderer);
        }

        $this->pushNodeRenderers();

        $this->parameters[self::PARAM_CONTENTFUL_RENDERER] = $this->contentfulRenderer;
    }

    /**
     * Add a renderer to the stack of renderers for rendering different links for different
     * Content Types in Contentful.
     *
     * @param \Contentful\RichText\NodeRenderer\NodeRendererInterface $renderer
     */
    protected function addNodeRenderer(\Contentful\RichText\NodeRenderer\NodeRendererInterface $renderer) {
        $this->renderers[] = $renderer;
    }

    /**
     * Adds all renderers to the contentful renderer
     */
    protected function pushNodeRenderers()
    {
        foreach ($this->renderers as $renderer) {
            $this->contentfulRenderer->pushNodeRenderer($renderer);
        }
    }

    /**
     * Reads the parameters from the sitemap / application components definition
     */
    protected function handleParameters()
    {
        $parameters = $this->parameters;

        if (isset($parameters[self::PARAM_HYPERLINK_FIELD])) {
            $this->hyperlinkField = explode(',', $parameters[self::PARAM_HYPERLINK_FIELD]);
        }

        if (isset($parameters[self::PARAM_CONTENT_TYPE])) {
            $this->contentType = explode(',', $parameters[self::PARAM_CONTENT_TYPE]);
        }

        if (isset($parameters[self::PARAM_URL_PREFIX])) {
            $this->urlPrefix = explode(',', $parameters[self::PARAM_URL_PREFIX]);
        }
    }


}