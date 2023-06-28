<?php

namespace Leonidas\Contracts\Admin\Component\Metabox;

use WP_Screen;

interface MetaboxBuilderInterface
{
    /**
     * @return $this
     */
    public function id(string $id): static;

    /**
     * @return $this
     */
    public function title(string $title): static;

    /**
     * @param string|array<string>|WP_Screen $screen
     *
     * @return $this
     */
    public function screen(string|array|WP_Screen $screen): static;

    /**
     * @return $this
     */
    public function context(?string $context): static;

    /**
     * @return $this
     */
    public function priority(?string $priority): static;

    /**
     * @return $this
     */
    public function args(?array $args): static;

    /**
     * @return $this
     */
    public function capsule(?MetaboxCapsuleInterface $capsule): static;

    public function get(): MetaboxInterface;
}
