<?php

/* @var $this yii\web\View */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Menu!</h1>
        <p class="lead">Select ingredients</p>
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'ingredients')->checkboxList(\yii\helpers\ArrayHelper::map($ingredients,'id','name')) ?>
        <?= Html::submitButton('Find dishes', ['class' => 'btn btn-lg btn-success']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <?= Alert::widget() ?>
    <div class="result">
        <div class="row">
            <? if(!empty($result)): ?>
                <? foreach($result as $item): ?>
                        <p><?=$item->name?></p>
                <? endforeach; ?>
            <? endif; ?>
        </div>
    </div>

</div>
