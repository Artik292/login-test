<?php

require 'connecting.php';

$app = new \atk4\ui\App($_SESSION['forum_name']);
$app->initLayout('Centered');

$forum=new Forum($db);
$forum->tryLoadBy('id',$_SESSION['forum_id']);

$view = $app->add(['View']);
$text = $view->add(['Text']);
$chat = $forum->ref('Chat');
$chat->setOrder('time');
//$text->set($chat['text']);
foreach($chat as $add) {
    $text->addParagraph($add['text']);
}
$form = $app->add('Form');
$form->addField('text');
$form->onSubmit(function($form) use ($view,$db,$forum) {
	$mes = new Chat($db);
  $mes['text'] = $form->model['text'];
  $mes['time'] = date('Y-m-d-G-i-s');
  $mes['forum_id'] = $forum->id;
  $mes->save();
	return $view->jsReload();
});
