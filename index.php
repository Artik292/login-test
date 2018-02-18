<?php

require 'connecting.php';

$app = new \atk4\ui\App('Прошу к нашему шалашу');
$app->initLayout('Centered');

$button = $app->add(['Button','Регистрация','big teal','icon'=>'add user'])
->link(['registration']);
$app->add(['ui'=>'hidden divider']);

$someone = new User($db);
$form = $app->layout->add('Form');
$form->setModel(new User($db));
$form->buttonSave->set('Вход');
$form->onSubmit(function($form) use ($someone) {
  //$form->model['nick_name']
  //$someone = $form->model->tryLoadBy('nick_name','fiqegqdj0[wqdw]');
  $someone->tryLoadBy('nick_name',$form->model['nick_name']);
  if ($someone['password'] == $form->model['password']) {
    $_SESSION['user_id'] = $someone->id;
    return new \atk4\ui\jsExpression('document.location="main.php"');
  } else {
    $someone->unload();
    $er = (new \atk4\ui\jsNotify('No such user.'));
    $er->setColor('red');
    return $er;
  }
});
