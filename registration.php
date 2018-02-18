<?php

require 'connecting.php';

$app = new \atk4\ui\App('Регистрация');
$app->initLayout('Centered');

$button = $app->add(['Button','Назад','small teal','icon'=>'reply'])
->link(['index']);
$app->add(['ui'=>'hidden divider']);

class Reg extends \atk4\data\Model {
	public $table = 'users';
function init() {
	parent::init();
  $this->addField('nick',['caption'=>'Nick name','required'=>TRUE]);
  $this->addField('pas1',['type'=>'password','caption'=>'Password','required'=>TRUE]);
  $this->addField('pas2',['type'=>'password','caption'=>'Password (repeat)','required'=>TRUE]);
}
}

$someone = new User($db);
$form = $app->layout->add('Form');
$form->setModel(new Reg($db));
$form->buttonSave->set('Зарегестрироваться');
$form->onSubmit(function($form) use ($someone) {
    if (!($form->model['pas1'] == $form->model['pas2'])) {
        return $form->error('pas1','Пароли не совпадают!');
    } else {
        $someone->tryLoadBy('nick_name',$form->model['nick']);
        if ($someone->loaded()) {
        //if ($someone['nick_name'] == $form->model['nick']) {
            return $form->error('nick','Такой ник уже есть.');
        } else {
            $someone['nick_name'] = $form->model['nick'];
            $someone['password'] = $form->model['pas1'];
            $someone->save();
            $someone->tryLoadBy('nick_name',$form->model['nick']);
            $_SESSION['user_id'] = $someone->id;
            return new \atk4\ui\jsExpression('document.location="main.php"');
        }
    }
});
