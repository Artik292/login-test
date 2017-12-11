<?php

require 'vendor/autoload.php';
require 'warehouse.php';
require 'loginform.php';

$app = new Warehouse(false);

$model = new User($app->db);
$model->load($_SESSION['user_id']);
$nick_name = $model['nick_name'];
$password = $model['password'];

echo "nick_name = ",$nick_name," password = ",$password;

$logout = $app->add(['Button','Logout','icon'=>'sign out'])
  ->link(['logout']);
