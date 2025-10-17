<?php

declare(strict_types=1);

namespace PhpUnitExtensions\Assertion;

trait JsonAssertionTrait
{
    abstract public function name(): int|string;

    abstract public function dataName(): int|string;

    /**
     * @param array<mixed> $data
     */
    public function getJsonAssertion(array $data): JsonAssertionFile
    {
        $classReflection = new \ReflectionClass($this);
        $classFileName   = $classReflection->getFileName();

        if ($classFileName === false) {
            throw new \RuntimeException('Anonymous classes are not supported');
        }

        $classDir = dirname($classFileName);

        // Format test name
        $testNameKebab     = (string) preg_replace('/([a-z])([A-Z])/', '$1-$2', $classReflection->getShortName());
        $testNameFormatted = strtolower($testNameKebab);

        if (str_ends_with($testNameFormatted, '-test')) {
            $testNameFormatted = substr($testNameFormatted, 0, -5);
        }

        // Format method name
        $methodNameKebab     = (string) preg_replace('/([a-z])([A-Z])/', '$1-$2', $this->name());
        $methodNameFormatted = strtolower($methodNameKebab);

        // Format test case name
        $testCaseName = trim((string) $this->dataName());

        if ($testCaseName === '') {
            $testCaseName = null;
        } else {
            $testCaseNameKebab = (string) preg_replace('/[^a-z0-9]+/i', '-', $testCaseName);
            $testCaseName      = strtolower($testCaseNameKebab);
        }

        $assertionPath = sprintf(
            '%s/_assertions/%s/%s%s.json',
            $classDir,
            $testNameFormatted,
            $methodNameFormatted,
            $testCaseName !== null ? '-' . $testCaseName : '',
        );

        return new JsonAssertionFile($assertionPath, $data);
    }
}
