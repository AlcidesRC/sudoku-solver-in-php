# Solving sudokus with PHP

> Demostration

[TOC]

## What are sudokus?

In its simplest and most common configuration, sudoku puzzles consists of a 9×9 grid with numbers appearing in some of the squares. The object of the puzzle is to fill the remaining squares, using all the numbers 1-9 exactly once in each row, column, and the nine 3×3 subgrids. Sudoku is based entirely on logic, without any arithmetic involved, and the level of difficulty is determined by the quantity and positions of the original numbers. The puzzle, however, raised interesting combinatorial problems for mathematicians, two of whom proved in 2005 that there are 6,670,903,752,021,072,936,960 possible sudoku grids.

### Sudoku rules

- Sudoku grid consists of 9x9 spaces.
- You can use only numbers from 1 to 9.
- Each 3×3 block can only contain numbers from 1 to 9.
- Each vertical column can only contain numbers from 1 to 9.
- Each horizontal row can only contain numbers from 1 to 9.
- Each number in the 3×3 block, vertical column or horizontal row can be used only once.
- The game is over when the whole Sudoku grid is correctly filled with numbers.

## About this application

This application solves sudoku puzzles using PHP via CLI or HTTP request.

> This implementation is based on [Simple sudoku solver](https://jsbin.com/sohudezihi/edit?js,output), a Javascript implementation by [Andrei Kashcha](https://twitter.com/anvaka) and published at [Programa JS para resolver sudokus](https://www.microsiervos.com/archivo/ordenadores/programa-javascript-resolver-sudokus.html) from [Microsiervos](https://microsiervos.com).

> This application differs from original implementation on the way candidate numbers are elected: in the original implementation those numbers **are calculated by brute force** on this implementation the candidates election takes care about previously elected in a row, column and subgrid.

This application can:

- Launch a `WrongSchemaException` exception the size is not 9×9 or not containing numbers from 1 to 9.

Or...

- Launch a `CannotBeSolvedException` exception if the initial sudoku doesn't follow the previously described rules. For example when a number is repeated on the same row, column or subgrid so sudoku puzzle cannot be solved.

Or...

- The desired solution.

There are tow ways to execute the application:

### Command Line Interface (CLI)

In [`./cli/example.php`](https://github.com/AlcidesRC/sudoku-solver-in-php/blob/main/src/cli/example.php) you can find a CLI example.

#### Executing the example

```bash
demos-sudoku$ make example-cli
```

##### Result

|  Input                           | Output                         |
|:--------------------------------:|:------------------------------:|
| ![thumb](./screenshot-input.png) | ![thumb](./screenshot-cli.png) |

### HTML

In [`./public/index.php`](https://github.com/AlcidesRC/sudoku-solver-in-php/blob/main/src/public/index.php) you can find a HTTP example.

#### Executing the example

```bash
demo-sudoku$ make example-html
```

##### Result

|  Input                           | Output                         |
|:--------------------------------:|:-------------------------------:|
| ![thumb](./screenshot-input.png) | ![thumb](./screenshot-html.png) |

## Built with

* [Docker](https://www.docker.com/) - Docker is an open platform for developing, shipping, and running applications.
* [nginx](https://www.nginx.com/) - Advanced Load Balancer, Web Server & Reverse Proxy.
* [PHP-FPM](https://www.php.net/) - FPM (FastCGI Process Manager) is a primary PHP FastCGI implementation containing some features (mostly) useful for heavy-loaded sites.
* [Make](https://www.gnu.org/software/make/) - GNU Make is a tool which controls the generation of executables and other non-source files of a program from the program's source files.

## Requirements

- Docker
- Git
- Web browser (if you want to see the HTML example)

## Assumptions

To simplify the setup process, nginx is attending requests from `http://localhost`

## Installation

To install this application just clone the repository into your local machine:

```bash
$ cd ~ && mkdir -p demos/sudoku-solver-in-php
~demos/sudoku-solver-in-php$ git clone https://github.com/AlcidesRC/sudoku-solver-in-php
```

## Usage

This repository contains a Makefile with frequent commands used to interact with the application:

### Available commands

```bash
~demos/sudoku-solver-in-php$ make

╔══════════════════════════════════════════════════════════════════════════════╗
║                                                                              ║
║                           .: AVAILABLE COMMANDS :.                           ║
║                                                                              ║
╚══════════════════════════════════════════════════════════════════════════════╝

· build                          Builds the service
· down                           Stops the service
· logs                           Exposes the service logs
· restart                        Restarts the service
· up                             Starts the service
· bash                           Opens a Bash terminal with main service
· composer-install               Runs <composer install>
· composer-update                Runs <composer update>
· composer-require               Runs <composer require>
· composer-require-dev           Runs <composer require>
· composer-remove                Runs <composer remove>
· composer-dump                  Runs <composer dump-auto>
· qa                             Checks the source code
· tests                          Runs the Tests Suites
· metrics                        Generates a report with some metrics
· cli                            Executes the example via CLI
· html                           Executes the example via HTTP
```

### Building the service

```bash
~demos/sudoku-solver-in-php$ make build
```

### Starting the service

```bash
~demos/sudoku-solver-in-php$ make up
```

### Installing PHP dependencies

```bash
~demos/sudoku-solver-in-php$ make composer-install
```

### Stablishing a SSH shell to main service

```bash
~demos/sudoku-solver-in-php$ make bash
```

### Quality Assurance

```bash
~demos/sudoku-solver-in-php$ make qa
```

This command is an alias that allows to execute the following tools:

- PHP Linter
- PHP Coding Standards Fixer (PHP-CS-Fixer)
- PHP Static Analyser (PHPStan)

### Running the test suite

```bash
~demos/sudoku-solver-in-php$ make tests
```

This command is an alias that allows to execute the following tools:

- PHP Unit
- PHP Coverage (PHPCOV)
- Infection

> The coverage report will be generated in `./coverage/html/index.html`

### Generating some metrics

```bash
~demos/sudoku-solver-in-php$ make metrics
```

> The metrics report will be generated in `./metrics/index.html`

### Stopping the service

```bash
~demos/sudoku-solver-in-php$ make down
```