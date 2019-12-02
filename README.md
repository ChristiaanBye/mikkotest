# mikkotest
This CLI tool generates the payment dates for the sales staff of a fictional company. The payment dates are determined by the following rules:

* Sales staff get a regular monthly fixed base salary and a monthly bonus.
* The base salaries are paid on the last day of the month unless that day is a Saturday or a Sunday (weekend). In that case, they are paid on the last weekday of the month.
* On the 15th of every month bonuses are paid for the previous month, unless that day is a weekend. In that case, they are paid the first Wednesday after the 15th.

The payment dates will be saved to a .csv file of which the user may specify the file name.

## Getting started
In order to get started as easily as possible and to ensure consistent behaviour across all systems, a Docker configuration is provided in the following repository:
 
* [mikkotest-docker](https://github.com/ChristiaanBye/mikkotest-docker)

Instructions as to how to set up the Docker container are present in the repository mentioned above.

Please note: the rest of the documentation assumes usage of above configuration. If not making use of the above configuration - or using a modified version - you might have to change certain commands according to your local environment and configuration.

After setting up the Docker container, please follow the following steps.
1. Clone this repository. 

    Please note that if you make use of the Docker configuration mentioned above that both this repository and the Docker repository reside next to each other in the same directory. For example:
    ```
    ParentDirectory/
    ├── mikkotest/
    └── mikkotest-docker/
    ```

1. Connect to the container using SSH:
    ```sh
    ssh mikko@127.0.0.1 -p 1337
    ```
    You may then input `test1234` when prompted for a password.

1. Change the directory to the working directory:
   ```sh
   cd /var/www/html/
   ```

1. Run `$ composer install`

## Running the application
1. If not already in the working directory, please change the directory to the working directory:
    ```sh
    cd /var/www/html/
    ```

1. Execute the application to generate the payment dates for the remainder of the current year with the following command:
    ```sh
    php application.php payment-dates:generate -f remainder-of-current-year.csv
    ```
    The value passed for the flag `-f` is the name of the outputted file and can be changed at own discretion.

## Extras
### Generating output for a given year
As the CLI tool was delivered in December, a single row will be outputted upon execution. Therefore an extra option `-y` was added in order to generate payment dates for a full year of the user's choice. For example, in order to generate the payment dates for 2020, the user would execute:
```sh
php application.php payment-dates:generate -f payment-dates-2020.csv -y 2020
```  
### Dry runs
If the user does not wish to output to csv but would rather output to the console instead, the option `--dry-run` can be passed. When outputting to the console, the file name is no longer mandatory. A dry run can be performed in conjunction with the usage of the `-y` flag.

## Running the tests
### Unit tests
The unit tests can be run by using the following command in the working directory:
```sh
phpunit
```
Upon unit test execution coverage information is automatically generated. This information is generated to the `build/coverage` directory within the working directory.

### Integration tests
The integration tests can be run by using the following command in the working directory:
```sh
phpunit --testsuite="Integration"
```

### All the tests!
A combination of both unit and integration tests can be run by using the following command in the working directory:
```sh
phpunit --testsuite="All"
```

## Running a mutation test
A mutation test can be performed by running the following command in the working directory:
```sh
infection
```

## Used libraries and frameworks
* `symfony/console` - To ease with base setup and integration testing
* `phpunit/phpunit` - For unit testing. Also required `phpunit/php-invoker` to enforce time limits on tests which are prone to infinite loops  
* `nesbot/carbon` - To ensure date and time sensitive tests are not affected by the continuous passing of time
* `mikey179/vfsstream` - To mock the file system for unit testing
* `infection/infection` - To mutant test the test suite