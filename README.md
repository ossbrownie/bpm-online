Bpm’online
==========

[![Latest Stable Version](https://poser.pugx.org/ossbrownie/bpm-online/v/stable)](https://packagist.org/packages/ossbrownie/bpm-online)
[![Total Downloads](https://poser.pugx.org/ossbrownie/bpm-online/downloads)](https://packagist.org/packages/ossbrownie/bpm-online)
[![Latest Unstable Version](https://poser.pugx.org/ossbrownie/bpm-online/v/unstable)](https://packagist.org/packages/ossbrownie/bpm-online)
[![License](https://poser.pugx.org/ossbrownie/bpm-online/license)](https://packagist.org/packages/ossbrownie/bpm-online)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://travis-ci.org/ossbrownie/bpm-online.svg?branch=master)](https://travis-ci.org/ossbrownie/bpm-online)

API access to a single marketing management platform 'CRM-system bpm’online'

# Sorry, this package is under development and may not work correctly.

## curl
A basic CURL wrapper for PHP (see [http://php.net/curl](http://php.net/curl) for more information about the libcurl extension for PHP)


## Requirements
- **PHP** = >= 7.0
- **EXT-CURL** = *
- **EXT-JSON** = *
- **ossbrownie/http-client** = ~0.0.4
- **ossbrownie/util** = ~0.0.5


## Installation
Add a line to your "require" section in your composer configuration:
```json
{
    "require": {
        "ossbrownie/bpm-online": "0.0.1"
    }
}
```


## Documentation
- [Usage](https://github.com/ossbrownie/bpm-online/wiki/Usage) - Example of using the Bpm’online


## Tests
To run the test suite, you need install the dependencies via composer, then run PHPUnit.
```bash
$> composer.phar install
$> ./vendor/bin/phpunit --colors=always --bootstrap ./tests/bootstrap.php ./tests
```


## License
Bpm’online is licensed under the [MIT License](https://opensource.org/licenses/MIT)


## Contact
Problems, comments, and suggestions all welcome: [oss.brownie@gmail.com](mailto:oss.brownie@gmail.com)
