<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;
use Leonidas\Library\Core\Asset\Traits\HasScriptDataTrait;

class Script extends AbstractAsset implements ScriptInterface
{
    use HasScriptDataTrait;

    /**
     * @var bool
     */
    protected $shouldLoadInFooter;

    /**
     * @var null|bool
     */
    protected $isAsync;

    /**
     * @var null|bool
     */
    protected $isDeferred;

    /**
     * @var null|string
     */
    protected $integrity;

    /**
     * @var null|bool
     */
    protected $isNoModule;

    /**
     * @var null|string
     */
    protected $nonce;

    /**
     * @var null|string
     */
    protected $referrerPolicy;

    /**
     * @var null|string
     */
    protected $type;

    protected ?ScriptLocalizationInterface $localization = null;

    public function __construct(
        string $handle,
        string $src,
        ?array $dependencies,
        $version = null,
        ?bool $shouldLoadInFooter = null,
        ?bool $shouldBeEnqueued = null,
        ?ConstrainerCollectionInterface $constraints = null,
        $localization = null,
        ?array $attributes = null,
        ?bool $isAsync = null,
        ?string $crossorigin,
        ?bool $isDeferred = null,
        ?string $integrity = null,
        ?bool $isNoModule = null,
        ?string $nonce = null,
        ?string $referrerPolicy = null,
        ?string $type = null
    ) {
        parent::__construct(
            $handle,
            $src,
            $dependencies,
            $version,
            $shouldBeEnqueued,
            $constraints,
            $attributes,
            $crossorigin
        );

        $shouldLoadInFooter && $this->shouldLoadInFooter = $shouldLoadInFooter;
        $isAsync && $this->isAsync = $isAsync;
        $isDeferred && $this->isDeferred = $isDeferred;
        $integrity && $this->integrity = $integrity;
        $isNoModule && $this->isNoModule = $isNoModule;
        $nonce && $this->nonce = $nonce;
        $referrerPolicy && $this->referrerPolicy = $referrerPolicy;
        $type && $this->type = $type;

        if ($localization) {
            $this->localization = $localization instanceof ScriptLocalizationInterface
                ? $localization
                : $this->createLocalization($localization);
        }
    }

    public function hasLocalization(): bool
    {
        return !empty($this->getLocalization());
    }

    protected function createLocalization(array $localization): ScriptLocalizationInterface
    {
        return new ScriptLocalization(
            $this->getHandle(),
            $localization['variable'],
            $localization['data']
        );
    }
}
