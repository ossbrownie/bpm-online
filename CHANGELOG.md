# Change Log

## dev-master (2019-06-12)

## 0.0.8 (2019-06-12)

- Updated CHANGELOG.md and README.md.
- Fixed key case in differents ResponseStatus.
- Changed unit tests.

## 0.0.7 (2019-03-27)

- Customized work with the filter IN.
- Added class Brownie\BpmOnline\DataService\Column\ColumnExpressionCollection and unitTest for it.

## 0.0.6 (2019-03-25)

- Added a batch request method to get the number of added contracts.

## 0.0.5 (2019-03-22)

- Updated composer.json
- Added up to 3 request attempts if http code 200,500 is not received.

## 0.0.4 (2019-03-20)

- The DateTime class has been added to form time in queries.
- Added class Brownie\BpmOnline\Util\DateTime
- Added unitTest for class Brownie\BpmOnline\Util\DateTime
- Fixed unit tests.

## 0.0.3 (2019-03-16)

- Added group filters.
- Added expressions for filters.
- Added batch query.
- Updated unitTest.

## 0.0.2 (2019-03-14)

- Updated unitTest and fixed scrutinizer issues.

## 0.0.1 (2019-03-13)

- Refactoring.
- Added class Brownie\BpmOnline\DataService\Response\DeleteContract
- Added class Brownie\BpmOnline\DataService\Response\InsertContract
- Added class Brownie\BpmOnline\DataService\Response\SelectContract
- Added class Brownie\BpmOnline\DataService\Response\UpdateContract
- Added class Brownie\BpmOnline\DataService\Response
- Added unitTest for class Brownie\BpmOnline\DataService\Response\DeleteContract
- Added unitTest for class Brownie\BpmOnline\DataService\Response\InsertContract
- Added unitTest for class Brownie\BpmOnline\DataService\Response\SelectContract
- Added unitTest for class Brownie\BpmOnline\DataService\Response\UpdateContract
- Added unitTest for class Brownie\BpmOnline\DataService\Response

## dev-master (2019-03-12)

- Refactoring.
- Updated composer.json, .scrutinizer.yml, .travis.yml
- Update annotations.

## dev-master (2019-03-11)

- Refactoring.
- Added unitTest for class Brownie\BpmOnline\DataService\Column\ColumnExpression
- Added unitTest for class Brownie\BpmOnline\DataService\Column\ColumnFilter
- Added unitTest for class Brownie\BpmOnline\DataService\Column\Expression\ColumnPath
- Added unitTest for class Brownie\BpmOnline\DataService\Column\Expression\ExpressionType
- Added unitTest for class Brownie\BpmOnline\DataService\Column\Expression\Parameter
- Added unitTest for class Brownie\BpmOnline\DataService\Column\Expression
- Added unitTest for class Brownie\BpmOnline\DataService\Contract\DeleteContract
- Added unitTest for class Brownie\BpmOnline\DataService\Contract\InsertContract
- Added unitTest for class Brownie\BpmOnline\DataService\Contract\SelectContract
- Added unitTest for class Brownie\BpmOnline\DataService\Contract\UpdateContract
- Added unitTest for class Brownie\BpmOnline\DataService\Contract
- Updated composer.json, .gitignore

## dev-master (2019-03-08)

Features:
- Initinal commit.
- Added authentication.
- Added minimal DataContract InsertQuery.
- Added minimal DataContract SelectQuery.
- Added minimal DataContract UpdateQuery.
- Added minimal DataContract DeleteQuery.
- Added minimal data Filters.
- Added unitTest for class Brownie\BpmOnline\Config.
- Added unitTest for class Brownie\BpmOnline\Exception\AuthenticationException.
- Added unitTest for class Brownie\BpmOnline\Exception\HttpCodeException.
- Added unitTest for class Brownie\BpmOnline\Exception\JsonException.
- Added unitTest for class Brownie\BpmOnline\Exception\ValidateException.
