## Installation

### Prerequisites

This extension requires:

* PHP 7.0 or higher
* Behat 3.x or higher

#### Install with composer:

```bash
$ composer require miamioh/behat-sensu-formatter
```

## Basic usage

Activate the extension by specifying its class in your `behat.yml`:

```text
# behat.yml
default:
    suites:
    ...

    extensions:
      miamioh\BehatSensuFormatter\BehatSensuFormatterExtension: ~
    ...
```

Then add it as a formatter in your `behat.yml` :

```text
#behat.yml
  ...
  formatters:
    SensuFormatter: ~
  ...
```
## Metric Check Type
If the check is going to be a metric check there is a change that needs to be made and another one that could be made depending on the check.
```text
#behat.yml
  ...
  extensions:
    miamioh\BehatSensuFormatter\BehatSensuFormatterExtension:
      checkType: 'metric'
  ...
```

This will add 3 lines of metrics to the output:
```
  behat.tests.run 2 1515546664
  behat.tests.passed 2 1515546664
  behat.tests.failed 0 1515546664
  OK: All 2 tests passed
```

The Description of the metric, the value of the metric and the timestamp the metric was created.  This information can then be used by Graphite to show a chart of passed and failed tests.

Additionally you could add the metricPreface parameter to your yml file to preface the metric name with specific information about the test run.

and another one that could be made depending on the check.
so maybe ``metricPreface: 'test.myapp'`` or something like ``metricPreface: 'test.chrome.myapp'`` if you wanted to collet all your test metrics when the test is run against chrome vs maybe safari.  when this preface is added then the output would be
```
  test.chrome.myapp.behat.tests.run 2 1515546664
  test.chrome.myapp.behat.tests.passed 2 1515546664
  test.chrome.myapp.behat.tests.failed 0 1515546664
  OK: All 2 tests passed
```
