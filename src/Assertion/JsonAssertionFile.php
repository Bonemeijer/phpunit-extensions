<?php

declare(strict_types=1);

namespace PhpUnitExtensions\Assertion;

use PHPUnit\Framework\TestCase;

class JsonAssertionFile
{
    /**
     * @param array<mixed> $data
     */
    public function __construct(
        public readonly string $path,
        public readonly array  $data,
    )
    {
    }

    public function assertSame(): void
    {
        $dataEncoded = json_encode(
            $this->data,
            JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );

        $dirName = dirname($this->path);

        if (!is_dir($dirName)) {
            // @TODO Yeah, no
            mkdir($dirName, 0777, true);
        }

        if (!file_exists($this->path) || UpdateAssertionsEnv::isActive()) {
            $result = file_put_contents($this->path, $dataEncoded);

            if ($result === false) {
                throw new \RuntimeException(
                    sprintf(
                        'Could not write assertion data to "%s"',
                        $this->path,
                    ),
                );
            }

            TestCase::markTestSkipped('updated assertion');
        }

        TestCase::assertJsonStringEqualsJsonFile(
            $this->path,
            $dataEncoded,
        );
    }
}
