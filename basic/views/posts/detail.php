<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Posts page';
?>

<script type="text/javascript">
    var postAjaxUrl = '<?=Url::to(["posts/ajax"]);?>';
</script>

<div id="post">
    <h2><?= Html::encode($post['name'])?></h2>
    <p class="post-date"><?= date('d.m.Y H:i', Html::encode($post['date']))?></p>
    <hr/>
    <div class="post-content"><?= Html::encode($post['content'])?></div>
    <p class="post-like"><b>Likes</b>: <span class="post-like-count"><?= Html::encode($post['general_likes'])?></span></p>
    <hr/>
</div>

<div id="post-comments">
    <h2>Comments</h2>
    <? 
        if($comments) {
            echo $this->render('comments', [
                'comments' => $comments
            ]); 
        }
    ?>    
</div>

<hr/>

<div id="add-comment">
    <h3>Добавить комментарий</h3>

    <div class="other-comment-block" data-item="0">
        <p>Ответ на следующий комментарий:</p>
        <div class="other-comment bg-warning"></div>
        <div class="btn btn-danger close-other-comment">Комментировать пост</div>
    </div>
    
    <div class="clear"></div>

    <?php $form = ActiveForm::begin([
        'id' => 'add-comment-form',
        'ajaxDataType' => 'json',
        'ajaxParam' => 'ajax',
        'fieldConfig' => [
            'template' => "{label}<br/><div>{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($commentForm, 'content')->textArea(['rows' => 6]) ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'add-comment-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

