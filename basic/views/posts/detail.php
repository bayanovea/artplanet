<?php
use yii\helpers\Html;
use yii\helpers\Url;

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
    <? // print_r($comments); ?>
    <? foreach ($comments as $key => $comment): ?>
        <?= Html::encode($comment['id']) ?>
        <?= Html::encode($comment['content']) ?>
    <? endforeach; ?>
    <?// print_r($comments); ?>
    <?/*= $this->render('comments', [
            'comments' => $comments
        ]) */?>
</div>

