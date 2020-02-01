# Configurations

With the installation of Yii you will find a *main* configuration file located at `protected/config/main.php`.  
A configuration is an array of key-value pairs. Each key represents the name of a property of the object to be configured, and each value the corresponding property's inital value.



## Database

```php
<?php
'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=homefooddb',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'schemaCachingDuration' => 180,
            'initSQLs' => array(
                "SET time_zone = '+7:00'" //for my country (Cambodia)
            ),
        ),
```

This is where you configure your database connection such as 
 - dbname   : database name
 - username : database user name
 - password : database password
 - chartset : database character set
 - initSQLs : initial SQL execute during runtime where above to set time_zone when saving record to database wherever hosting we hosted

## Always Load Component

```php

<?php
require_once( dirname(__FILE__) . '/../components/globals.php');
require_once( dirname(__FILE__) . '/../components/helpers.php');

```

The comp
