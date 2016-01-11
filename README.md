# HR system

## Requirements

- **PHP 5.6** or higher
- nodejs - [grunt](http://gruntjs.com/) and [bower](http://bower.io/)
- [composer](https://getcomposer.org/)

## Installation

Install composer dependencies:

    composer install

Install grunt and bower globally (requires root permissions):

    npm install -g grunt-cli bower

Install bower and npm dependencies:

    bower install
    npm install

Build all assets:

    grunt build

Reload application database..

    app/console doctrine:database:create
    app/console doctrine:migrations:migrate
    app/console app:fixtures

User will be created:

    email: user@hr.lt
    password: S3cretpassword

Start serving application in **dev** environment:

    app/console server:run

## Testing

### Behat

See [behat3](http://docs.behat.org/en/latest/) for reference.

Prepare test database:

    app/console doctrine:database:create --env=test
    app/console doctrine:migrations:migrate --env=test

To run behat tests:

    bin/behat
