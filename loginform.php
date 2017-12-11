<?php

class LoginForm extends \atk4\ui\Form
{
    function init() {
        parent::init();
        $this->setModel(clone $this->app->user, ['nick_name', 'password']);
        $this->onSubmit(function($form) {
          if ($form->model['nick_name'] == '') {
            return $form->error('nick_name','Please, enter data.');
          } else {
                  if ($form->model['password'] == '') {
                    return $form->error('password','Please, enter data.');
                  } else {

                          $this->app->user->tryLoadBy('nick_name', $form->model['nick_name']);
                          if ($this->app->user['password'] == $form->model['password']) {
                              // Auth successful!
                              $_SESSION['user_id'] = $this->app->user->id;

                              return new \atk4\ui\jsExpression('document.location="main.php"');
                          } else {
                              $this->app->user->unload();
                              return $form->error('nick_name', 'No such user.');
                          }
                      }
                  }
        });
    }
}
