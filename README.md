Bpm’online
==========

[![License](https://poser.pugx.org/ossbrownie/bpm-online/license)](https://packagist.org/packages/ossbrownie/bpm-online)
[![Latest Stable Version](https://poser.pugx.org/ossbrownie/bpm-online/v/stable)](https://packagist.org/packages/ossbrownie/bpm-online)
[![Latest Unstable Version](https://poser.pugx.org/ossbrownie/bpm-online/v/unstable)](https://packagist.org/packages/ossbrownie/bpm-online)
[![Total Downloads](https://poser.pugx.org/ossbrownie/bpm-online/downloads)](https://packagist.org/packages/ossbrownie/bpm-online)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/ossbrownie/bpm-online/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://travis-ci.org/ossbrownie/bpm-online.svg?branch=master)](https://travis-ci.org/ossbrownie/bpm-online)

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.0-brightgreen.svg)](https://php.net/)

API access to a single marketing management platform 'CRM-system bpm’online' >= 7.10

## Requirements
- **PHP** = >= 7.0
- **EXT-CURL** = *
- **EXT-JSON** = *
- **ossbrownie/http-client** = 0.0.7
- **ossbrownie/util** = 0.0.5

For more information about the extensions see:

**curl** - [https://www.php.net/curl](https://www.php.net/curl)

**json** - [https://www.php.net/json](https://www.php.net/json)


## Installation
Add a line to your "require" section in your composer configuration:
```json
{
    "require": {
        "ossbrownie/bpm-online": "0.0.7"
    }
}
```


## Documentation
- [DataService Contract InsertQuery.](https://github.com/ossbrownie/bpm-online/wiki/Data-Contract-InsertQuery) 
- [DataService Contract SelectQuery.](https://github.com/ossbrownie/bpm-online/wiki/Data-Contract-SelectQuery) 
- [DataService Contract UpdateQuery.](https://github.com/ossbrownie/bpm-online/wiki/Data-Contract-UpdateQuery) 
- [DataService Contract DeleteQuery.](https://github.com/ossbrownie/bpm-online/wiki/Data-Contract-DeleteQuery) 
- [DataService Contract BatchQuery.](https://github.com/ossbrownie/bpm-online/wiki/Data-Contract-BatchQuery) 
- [DataService DateTime.](https://github.com/ossbrownie/bpm-online/wiki/DateTime) 
- [DataService Filters.](https://github.com/ossbrownie/bpm-online/wiki/Filters)


## Tests
To run the test suite, you need install the dependencies via composer, then run PHPUnit.
```bash
$> composer.phar install
$> ./vendor/bin/phpunit --bootstrap ./tests/bootstrap.php ./tests
```


## License
Bpm’online is licensed under the [MIT License](https://opensource.org/licenses/MIT)


## Contact
Problems, comments, and suggestions all welcome: [oss.brownie@gmail.com](mailto:oss.brownie@gmail.com)
