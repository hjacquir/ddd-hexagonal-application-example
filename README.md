# DDD-hexagonal-application-example

This project is an example of hexagonal architecture with an DDD (Domain Driven Design) application on a use case. 

## More information about hexagonal architecture

https://en.wikipedia.org/wiki/Hexagonal_architecture_(software)

## Use case

Implement a REST API in PHP which makes it possible to query the presence of a keyword among
the commits messages of a given day on [GH Archive] (https://www.gharchive.org /).
For example a curve of the number of commits during the day of 2018-01-01 which have the keyword "fix".

## Context schema

![](schema.png)

## Features

* Implement a command line client to download the archives for
  a given day and store them in the database.

* Expose an API allowing to query the database using a keyword and a date.

## Scenario

```Gherkin
When I enter a date and a keyword
Then for the search criteria entered the total number of events is displayed
And the total number by type of event is displayed
And the total number by type of events per hour is displayed
And the last 5 commits are visible
```

## Requirements

* PHP > 7.4

## Use development environment :computer:

You only need `make`, `docker` and `docker-compose` installed to start the development environment.

### Start the development environment

The following command will start the development environment.
You can access to the application at http://127.0.0.1:8000/ :

```bash
make start
```

### Access to a shell in the PHP container

```bash
make shell
```

### Tests tools

You can run PHPUnit with the following command:
```bash
# Run the unit test suite
make unit-test

# Run the functionnal test suite
make func-test
```

### Stop the development environment

You can stop the development environment running this command:
```bash
make stop
```

### Clean the development environment

You can clean the development environment (docker images, vendor, ...) running this command:
```bash
make clean
```

### Makefile targets

You can get available targets by running:
```bash
make
```

```bash
build                          Build the docker stack
pull                           Pulling docker images
shell                          Enter in the PHP container
start                          Start the docker stack
stop                           Stop the docker stack
clean                          Clean the docker stack
vendor                         Install composer dependencies
unit-test                      Run PhpUnit unit testsuite
func-test                      Run PhpUnit functionnal testsuite
```

### Usage

## Download Github archive remote file

* Define in your .env configuration file the path to the directory that will store the downloaded archive files :
`LOCAL_DOWNLOADED_FILE_PATH`
* Enter in your shell and launch the command : `bin/console app:download 2014-02-01` with the date to fetch (e.g : 2012-02-02 here)
to verbose all log message add the options : `-vvv` like `bin/console app:download 2014-02-01 -vvv`