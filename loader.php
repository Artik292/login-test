<?php

require 'connecting.php';

$app = new \atk4\ui\App('fqew');
$app->initLayout('Centered');

echo $app->stickyGet('id');
echo $_GET['id'];

$forum = new Forum($db);
$forum->tryLoadBy('id',$_GET['id']);
$text = $forum->ref('Chat');
/*if ($text['text'] == null) {
  $text['text']='Чат был создан '.date('Y-m-d-G-i-s');
  $text['time'] = date('Y-m-d-G-i-s');
  $text->save(); //Кароч, тут надо проверять по сессии, при создании
  нового форума, создаёться сессия и кидает на этото файл.
  По сессии проверка, первый раз ли на него заходят,
  и если да, то пишется время создания.
}*/
$_SESSION['forum_name'] = $forum['name'];
$_SESSION['forum_id'] = $forum['id'];

header('Location: forum.php');
