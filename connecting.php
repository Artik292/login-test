<?php

session_start();
date_default_timezone_set('UTC');

require 'vendor/autoload.php';

if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
     $db = \atk4\data\Persistence::connect($_ENV['CLEARDB_DATABASE_URL']);
 } else {
     $db = \atk4\data\Persistence::connect('mysql:host=127.0.0.1;dbname=users;charset=utf8', 'root', '');
 }

class User extends \atk4\data\Model {
	public $table = 'users';
function init() {
	parent::init();
	$this->addField('nick_name',['required'=>TRUE]);
  $this->addField('password',[/*'type'=>'password',*/'required'=>TRUE]);
}
}

class Forum extends \atk4\data\Model {
	public $table = 'forum';
function init() {
	parent::init();
	$this->addField('name',['required'=>TRUE]);
  $this->hasMany('Chat',new Chat);
}
}

class Chat extends \atk4\data\Model {
	public $table = 'chat';
function init() {
	parent::init();
	$this->addField('text');
  $this->addField('time');
  $this->hasOne('forum_id', [new Forum(),'caption'=>'Forum'])->addTitle();
}
}
