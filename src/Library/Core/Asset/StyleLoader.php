<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Contracts\Ui\Asset\StyleLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;

class StyleLoader implements StyleLoaderInterface
{
    /**
     * @var StyleCollectionInterface
     */
    protected $styles;

    public function __construct(StyleCollectionInterface $styles)
    {
        $this->styles = $styles;
    }

    protected function getStyles(): StyleCollectionInterface
    {
        return $this->styles;
    }

    public function load(ServerRequestInterface $request)
    {
        foreach ($this->getStyles()->getStyles() as $style) {
            if ($style->shouldBeLoaded($request)) {
                if ($style->shouldBeEnqueued()) {
                    $this->enqueueStyle($style);
                } else {
                    $this->registerStyle($style);
                }
            }
        }
    }

    public static function registerStyle(StyleInterface $style)
    {
        wp_register_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );
    }

    public static function enqueueStyle(StyleInterface $style)
    {
        wp_enqueue_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );
    }

    public static function createStyleTag(StyleInterface $style): string
    {
        return Html::tag('link', [
            'rel' => 'stylesheet',
            'id' => static::getIdAttribute($style),
            'href' => static::getHrefAttribute($style),
            'media' => $style->getMedia(),
            'hreflang' => $style->getHrefLang(),
            'title' => $style->getTitle(),
            'disabled' => $style->isDisabled(),
            'crossorigin' => $style->getCrossorigin(),
        ] + $style->getAttributes()) . "\n";
    }

    public static function mergeStyleTag(string $tag, StyleInterface $style): string
    {
        return static::createStyleTag($style);
    }

    protected static function getIdAttribute(StyleInterface $style): string
    {
        return "{$style->getHandle()}-css";
    }

    public static function getHrefAttribute(StyleInterface $style): string
    {
        return null !== $style->getVersion()
            ? "{$style->getSrc()}?ver={$style->getVersion()}"
            : $style->getSrc();
    }
}
