<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Posts page';
?>

<script type="text/javascript">
    var postAjaxUrl = '<?=Url::to(["posts/ajax"]);?>';
</script>

<div id="add-post-block">
	<div class="btn btn-success show-add-form">Добавить пост</div>	
	   
    <?php $form = ActiveForm::begin([
        'id' => 'add-post-form',
        'options' => ['class' => 'form-horizontal'],
        'ajaxDataType' => 'json',
        'ajaxParam' => 'ajax',
        'enableClientValidation' => false,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    
    <h3>Добавить пост</h3>
    <?= $form->field($postForm, 'name') ?>
    <?= $form->field($postForm, 'content')->textArea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'add-post-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div id="posts">
    <? foreach ($posts as $post): ?>  
        <? if(!$post['general_likes']) $post['general_likes'] = 0; ?>
    	<div class="posts-list" data-item="<?= Html::encode($post['id']) ?>">
    		<p class="posts-list-date"><?= Html::encode(date('d.m.Y H:i', $post['date'])) ?></p>
    		<a href="<?= Url::to(['posts/'.$post['id']]) ?>" class="posts-list-head"><?= Html::encode($post['name']) ?></a>
    		<p class="posts-list-like">Likes count: <span class="posts-list-likes-num"><?= Html::encode($post['general_likes']) ?></span></p>
    		<p class="posts-list-comments">Comments count: <?= Html::encode($post['comments_count']) ?></p>
            <div class="btn btn-default btn-like-post">Like</div>
            <div class="btn btn-default btn-dislike-post">Dislike</div><br/>
            <div class="btn btn-danger delete-post">Удалить пост</div>
    	</div>
    	<hr/>
    <? endforeach; ?>
</div>

