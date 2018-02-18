<?php

require 'vendor/autoload.php';
require 'warehouse.php';
require 'loginform.php';

$app = new Warehouse(false);
$app->user->tryLoadBy('nick_name', $_SESSION['nick_name']);
  if ($app->user['password'] == $_SESSION['password']) {
        $_SESSION['user_id'] = $app->user->id;
        header('Location: main.php');
                }
