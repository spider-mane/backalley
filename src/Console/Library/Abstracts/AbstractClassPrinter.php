<?php

namespace Leonidas\Console\Library\Abstracts;

use Closure;
use Composer\InstalledVersions;
use Leonidas\Console\Library\PsrPrinterFactory;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\InterfaceType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\TraitType;

abstract class AbstractClassPrinter
{
    public const CORE = 'core';

    protected const SIGNATURES = [];

    protected string $namespace;

    protected string $class;

    public function __construct(string $namespace, string $class)
    {
        $this->namespace = $namespace;
        $this->class = $class;
    }

    public function printFile(): string
    {
        return $this->print(
            fn (PhpNamespace $namespace) => $this->addMethods(
                $this->setupClass($namespace),
                $this->getNativeSignatures()
            )
        );
    }

    protected function print(Closure $builder): string
    {
        $file = new PhpFile();

        $file->setStrictTypes(true);

        $builder($file->addNamespace($this->namespace));

        return $this->getPrinter()->printFile($file);
    }

    protected function getPrinter(): Printer
    {
        $version = InstalledVersions::getVersion('nette/php-generator');

        return version_compare($version, '4.0', '>=')
            ? PsrPrinterFactory::compat4()
            : PsrPrinterFactory::compat3();
    }

    protected function getNativeSignatures(): array
    {
        return static::SIGNATURES;
    }

    /**
     * @param ClassType|InterfaceType|TraitType $class
     * @param array<string,array<string,string>> $signatures
     *
     * @return ClassType|InterfaceType|TraitType $class
     */
    protected function addMethods($class, array $signatures)
    {
        foreach ($signatures as $method => $signature) {
            $this->addMethod($class, $method, $signature);
        }

        return $class;
    }

    /**
     * @param ClassType|InterfaceType|TraitType $class
     */
    protected function addMethod($class, string $name, array $signature): void
    {
        $call = $signature['call'] ?? $name;

        $swap = $this->getMethodPassReplacements();
        $pass = str_replace($swap[0], $swap[1], $signature['pass'] ?? '');

        $swap = $this->getMethodGiveReplacements();
        $return = str_replace(
            [...$swap[0], ...$strip = ['?', '&'], '$this'],
            [...$swap[1], ...$this->mapSymbols($strip), $this->getClassFqn()],
            $give = $signature['give'] ?? 'void'
        );

        $method = $class->addMethod($name)
            ->setReturnNullable(str_contains($give, '?'))
            ->setReturnReference(str_contains($give, '&'))
            ->setReturnType($return)
            ->setPublic();

        if (!$class->isInterface()) {
            $method->setBody($this->getMethodBody($call, $pass, $give));
        }

        $params = ($take = $signature['take'] ?? false)
            ? explode(', ', $take)
            : [];

        foreach ($params as $param) {
            $this->addParameter($method, $param);
        }

        if ('$this' === $give) {
            $method->addComment('@return ' . '$this');
        }
    }

    protected function getClassFqn(): string
    {
        return $this->namespace . '\\' . $this->class;
    }

    protected function getMethodPassReplacements(): array
    {
        return [[], []];
    }

    protected function getMethodGiveReplacements(): array
    {
        return [[], []];
    }

    protected function getMethodBody(string $call, string $pass, string $give): string
    {
        $action = sprintf('$this->%s->%s(%s);', static::CORE, $call, $pass);

        return ('void' === $give) ? $action : 'return ' . $action;
    }

    protected function addParameter(Method $method, string $param): void
    {
        $parts = explode(' ', $param);

        $swap = $this->getParameterTypeReplacements();
        $type = str_replace(
            [...$swap[0], ...$strip = ['*']],
            [...$swap[1], ...$this->mapSymbols($strip)],
            $parts[0]
        );

        $swap = $this->getParameterNameReplacements();
        $name = str_replace(
            [...$swap[0], ...$strip = ['$', '?', '&', '...']],
            [...$swap[1], ...$this->mapSymbols($strip)],
            $parts[1]
        );

        $method->setVariadic(str_contains($parts[1], '...'));

        $parameter = $method->addParameter($name)
            ->setNullable(str_contains($parts[1], '?'))
            ->setReference(str_contains($parts[1], '&'))
            ->setType($type);

        if ($default = $parts[3] ?? false) {
            if ('null' === $default) {
                $default = null;
            } elseif ('true' === $default) {
                $default = true;
            } elseif ('false' === $default) {
                $default = false;
            } elseif (is_numeric($default)) {
                $default = (int) $default;
            } elseif (is_string($default)) {
                $default = trim($default, '\'"');
            }

            $parameter->setDefaultValue($default);
        }
    }

    protected function mapSymbols(array $symbols): array
    {
        return array_pad([], count($symbols), '');
    }

    protected function getParameterTypeReplacements(): array
    {
        return [[], []];
    }

    protected function getParameterNameReplacements(): array
    {
        return [[], []];
    }

    /**
     * @return ClassType|TraitType|InterfaceType
     */
    abstract protected function setupClass(PhpNamespace $namespace);
}