<?php
/**
 * Created by Jens on 1-2-2019.
 */

namespace getcloudcontrol\cloudcontrolContentfulComponents\renderer;


use CloudControl\Cms\cc\Request;
use CloudControl\Cms\util\StringUtil;
use Contentful\RichText\Node\EntryHyperlink;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\NodeRenderer\NodeRendererInterface;
use Contentful\RichText\RendererInterface;

class HyperlinkRenderer implements NodeRendererInterface
{
    protected $urlPrefix;
    protected $hyperlinkField = 'slug';
    protected $contentType;

    /**
     * HyperlinkRenderer constructor.
     * @param string $urlPrefix
     * @param string $hyperlinkField
     * @param string $contentType
     */
    public function __construct($hyperlinkField, $contentType, $urlPrefix = null)
    {
        $this->urlPrefix = $urlPrefix;
        $this->hyperlinkField = $hyperlinkField;
        $this->contentType = $contentType;
    }


    /**
     * This method must return whether the current node renderer supports rendering
     * for the given node.
     *
     * In this example, we check first if the node is of type EntryHyperlink,
     * and second whether the entry is of content type "blogPost".
     * @param NodeInterface $node
     * @return bool
     */
    public function supports(NodeInterface $node): bool
    {
        if (!$node instanceof EntryHyperlink) {
            return false;
        }

        /** @var \Contentful\Delivery\Resource\Entry $entry */
        $entry = $node->getEntry();

        return $entry->getContentType()->getId() === $this->contentType;
    }

    /**
     * This method is supposed to transform a node object into a string
     * @param RendererInterface $renderer
     * @param NodeInterface $node
     * @param array $context
     * @return string
     */
    public function render(RendererInterface $renderer, NodeInterface $node, array $context = []): string
    {
        /** @var \Contentful\Delivery\Resource\Entry $entry */
        $entry = $node->getEntry();

        $content = current($node->getContent());

        $prefix = Request::$subfolders . (!empty($this->urlPrefix) ? $this->urlPrefix . '/' : '');
        $slug = StringUtil::slugify($entry->get($this->hyperlinkField));

        return \sprintf(
            '<a href="%s">%s</a>',
            $prefix . $slug,
            $content->getValue()
        );
    }
}