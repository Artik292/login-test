<?php
class Warehouse extends \atk4\ui\App
{
    /**
     * Currently logged in user
     */
    public $user;
    function __construct($auth = true) {
        if (is_dir('public')) {
            $this->cdn['atk'] = 'public';
        }
        parent::__construct('Login form v0.2');
        // Connect to database (Heroku or Local)
        if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            $this->db = \atk4\data\Persistence::connect($_ENV['CLEARDB_DATABASE_URL']);
        } else {
            $this->db = \atk4\data\Persistence::connect('mysql:host=127.0.0.1;dbname=users;charset=utf8', 'root', '');
            //'mysql:host=127.0.0.1;dbname=warehouse', 'root', 'root');
        }
        $this->db->app = $this;
        $this->user = new User($this->db);
        session_start();
        if (!$auth) {
            $this->initLayout('Centered');
            return;
        }
        if (isset($_SESSION['user_id'])) {
            $this->user->tryLoad($_SESSION['user_id']);
        }
        if(!$this->user->loaded()) {
            $this->initLayout('Centered');
            $this->layout->add(['Message', 'Login Required', 'error']);
            $this->layout->add(['Button', 'Login', 'primary'])->link('index.php');
            exit;
        }
        /*$a = new Article($this->db);
        $a->addCondition('stock', '<', 0);
        $c = $a->action('count')->getOne();
        if ($c>0) {
            $this->layout->menuRight->addItem(null, ['stock', 'negative'=>true])->add(['Label', 'There are '.$c.' articles with negative stock', 'red']);
        }*/
    }
}

class User extends \atk4\data\Model {
 public $table = 'users';
function init() {
 parent::init();
 $this->addField('nick_name');
  $this->addField('password');
}
}
