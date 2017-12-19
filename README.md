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
