<?php

require 'vendor/autoload.php';

 //$db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=users;charset=utf8', 'root', '');

 require 'warehouse.php';
 require 'loginform.php';

 $app = new Warehouse(false);
 $app->layout->add(['Message','Sign in']);
 $app->layout->add(new LoginForm());

 $app->add(['ui'=>'divider']);

 $reg_button = $app->layout->add(['Button','Sign up','big green'])
    ->link(['registration']);
