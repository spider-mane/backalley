<?php

namespace Leonidas\Library\Core\Http\Form;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Http\Form\FormInterface;
use Leonidas\Library\Admin\Forms\Validators\CsrfCheck;
use Leonidas\Library\Core\Auth\Nonce;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;

abstract class AbstractFormHandler implements FormInterface
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     *
     */
    public function __construct()
    {
        $this->config = $this->config();
    }

    /**
     *
     */
    public function process(ServerRequestInterface $request): FormProcessingCacheInterface
    {
        return $this->formSubmissionManager()->process($this->request($request));
    }

    /**
     *
     */
    public function formFields(ServerRequestInterface $request): array
    {
        $fieldData = $this->config['fields'];
        $controllers = $this->formFieldControllers();

        foreach ($fieldData as $field => &$data) {
            $controller = $controllers[$field];

            $data['name'] = $controller->getRequestVar();
            $data['value'] = $controller->getPresetValue($request);
        }

        return $fieldData;
    }

    /**
     * @return string[]
     */
    public function verificationFields(ServerRequestInterface $request): array
    {
        return ['nonce' => $this->createCsrfManager()->renderField()];
    }

    /**
     *
     */
    protected function formSubmissionManager(): FormSubmissionManagerInterface
    {
        return (new FormSubmissionManager())
            ->setValidators($this->formRequestValidators())
            ->setFields(...$this->formFieldControllers())
            ->setProcessors(...$this->formDataProcessors());
    }

    /**
     * @return FormValidatorInterface[]
     */
    protected function formRequestValidators(): array
    {
        return ['nonce' => new CsrfCheck($this->createCsrfManager())];
    }

    /**
     *
     */
    protected function createCsrfManager(): CsrfManagerInterface
    {
        $nonce = $this->config['nonce'];

        return new Nonce($nonce['name'], $nonce['action'], $nonce['exp'] ?? null);
    }

    /**
     *
     */
    protected function request(ServerRequestInterface $request): ServerRequestInterface
    {
        return $request;
    }

    /**
     * @return FormDataProcessorInterface[]
     */
    protected function formDataProcessors(): array
    {
        return [];
    }

    /**
     * @return FormFieldControllerInterface[]
     */
    abstract protected function formFieldControllers(): array;

    /**
     * @return array
     */
    abstract protected function config(): array;
}