# PHP Script template
A simple script template that has some useful tools in PHP.

## How does it work?
Simple, download this project, start to code your script inside the Scripts directory, and then modify the `script.php` file. <br>
The Template will help you with the configuration of your script, handle database connections and the queue schemas*

*not implemented yet.

## Using configuration Helper

In the `script.php` you'll see a static call to a class method to get a congig, this will load the configuration file `config.json` inside Config directory, this file should follow the config.json.example pattern. <br>
The config.json will be in array format inside the global var `$config`.

## Using Database Helper
A PDO connection will be made calling the `Connector` class of the connection you want, like in this example:
```php
    <?php
    use Database\Postgres;

    $pg = new Postgres\Connector("pglocal");
    $conn = $pg->connect();
```

The `pglocal` is the nabe of the connetion inside the config.json file.
<br>
Simple that way.