<?php

 require 'vendor/autoload.php';
 require 'warehouse.php';
 require 'loginform.php';

 $app = new Warehouse(false);
 $app->layout->add(['Header','Sign up','massive']);

 $form = $app->layout->add('Form');
 $form->setModel(new User($app->db));
 $form->onSubmit(function($form) {
  if ($form->model['nick_name'] == '') {
    return $form->error('nick_name', "This field mustn't be empty. ");
  } else {
      if ($form->model['password'] == '') {
        return $form->error('password', "This field mustn't be empty. ");
      } else {
        $form->model->save();
        $form->success('Record updated');
        return new \atk4\ui\jsExpression('document.location = "main.php" ');
      }
  }
 });
