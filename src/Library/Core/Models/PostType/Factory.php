<?php

namespace Leonidas\Library\Core\Models\PostType;

use Exception;
use Leonidas\Contracts\Options\PostTypeOptionHandlerInterface;
use Leonidas\Library\Core\Models\AbstractWpConfigModelFactory;
use WP_Post_Type;

class Factory extends AbstractWpConfigModelFactory
{
    /**
     *
     */
    public function create(array $postTypes): array
    {
        return parent::create($postTypes);
    }

    /**
     *
     */
    public function build(string $name, array $args): object
    {
        $labels = $args['labels'] ?? [];
        $options = $args['options'] ?? [];
        $rewrite = $args['rewrite'] ?? [];

        unset($args['labels'], $args['rewrite'], $args['options']);

        $postType = (new PostType($name))
            ->setArgs($args)
            ->setLabels($labels)
            ->setRewrite($rewrite)
            ->register()
            ->getRegisteredPostType();

        if (isset($this->optionHandlers)) {
            $this->processOptions($options, $postType);
        }

        return $postType;
    }

    /**
     *
     */
    protected function processOptions($options, WP_Post_Type $postType)
    {
        foreach ($options as $option => $args) {
            $handler = $this->optionHandlers[$option] ?? null;

            if (!$handler) {
                throw new Exception("There is no registered handler for the {$option} option provided");
            }

            if ($handler && in_array(PostTypeOptionHandlerInterface::class, class_implements($handler))) {
                $handler::handle($postType, $args);
            } else {
                throw new Exception("{$handler} is not a valid option handler");
            }
        }
    }
}
