# Bonemeijer/phpunit-extensions

A simple library of helper for PhpUnit tests.

The goal is to provide some simple time-saving PhpUnit extensions.

[![Latest Stable Version](https://poser.pugx.org/bonemeijer/phpunit-extensions/v/stable)](https://packagist.org/packages/bonemeijer/phpunit-extensions)
[![Total Downloads](https://poser.pugx.org/bonemeijer/phpunit-extensions/downloads)](https://packagist.org/packages/bonemeijer/phpunit-extensions)
[![License](https://poser.pugx.org/bonemeijer/phpunit-extensions/license)](https://packagist.org/packages/bonemeijer/phpunit-extensions)

### Installing

This project is still in beta. Backwards incompatible changes **will** be introduced during this time.

```
composer require bonemeijer/phpunit-extensions --dev
```

## JSON Assertion

This package provides a quick way to assert arbitrary data by dumping it to a JSON file and comparing it afterward.

Example:

```php
class JsonAssertionTraitTest extends TestCase
{
    // This trait provides the functionality
    use JsonAssertionTrait;

    public function testSomething(): void
    {
        $someUnit = new SomeUnit();
        
        try {
            $output = $someUnit->doSomething();
        } catch (\Throwable $exception) {
            // Capture exception to use in assertion data
        }
            
        // This will build the assertion file. Nothing is dumped or asserted yet.
        // The received data should be the current state
        $assertion = $this->getJsonAssertion(
            [
                'output'    => $output,
                'exception' => isset($exception)
                    ? [
                        'class'   => get_class($exception),
                        'message' => $exception->getMessage(),
                    ]
                    : null,
            ],
        );
        
        // This will run the assertion logic
        $assertion->assertSame();
    }
}
```

When calling `assertSame()`, the following logic will be applied:

- If the assertion file does not exist, it will be created and the current test will be marked as `skipped`.
- If the assertion file exists, the data passed to `getJsonAssertion` will be compared to the dumped file. If it
  matches, the test will pass. If it does not match, the test will fail.

### Updating assertions

To quickly update any assertions, you can set the `UPDATE_ASSERTIONS=1` environment variable. Or use the shortcut
`UA=1`.

```shell
# Update all assertions
UPDATE_ASSERTIONS=1 vendor/bin/phpunit

# Update all assertions using shortcut
UA=1 vendor/bin/phpunit 

# Update only a specific test
UA=1 vendor/bin/phpunit --filter SomeUnitTest
```

When you commit the assertion dump to a VCS like GIT, you can then easily verify any changes by rerunning
the test suite with `UPDATE_ASSERTIONS=1`. The GIT diff will show you the changes in output.

## Deployment

Don't. Don't deploy debug tools. Which is why I recommend using the `--dev` flag during installation.

## Versioning

This package uses [SemVer](http://semver.org/) for versioning. For the versions available, see the
[tags on this repository](https://github.com/Bonemeijer/phpunit-extensions/tags).

## Authors

* **Maurice Bonemeijer** - *Initial work* - [Bonemeijer](https://github.com/Bonemeijer)

See also the list of [contributors](https://github.com/Bonemeijer/phpunit-extensions/contributors) who participated in
this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
