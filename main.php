<?php

require 'connecting.php';

$app = new \atk4\ui\App('Главная комната:');
$app->initLayout('Centered');

$vir = $app->add('VirtualPage');
          $vir->set(function($vir) use ($db) {
            $form = $vir->add('Form');
            $form->setModel(new Forum($db),['name']);
            $form->onSubmit(function($form) {
            $form->model->save();
            return [$form->success('Форум добавлен!'),new \atk4\ui\jsExpression('document.location="main.php"')];
            });
          });

$grid = $app->layout->add('Grid');
$grid->setModel(new Forum($db),['name']);
$grid->addQuickSearch(['name']);
$grid->menu->addItem(['Add Country', 'icon' => 'add square'])->on('click', new \atk4\ui\jsModal('Work',$vir));
$grid->addDecorator('name', new \atk4\ui\TableColumn\Link('loader.php?id={$id}'));
