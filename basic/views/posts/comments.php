<? use yii\helpers\Html; ?>

<? foreach ($comments as $comment): ?>
        <div class="post-comment" data-item="<?= Html::encode($comment['id'])?>">
            <p class="comment-date"><?= date('d.m.Y H:i', Html::encode($comment['date']))?></p>
            <p class="comment-content"><?= Html::encode($comment['content']) ?></p>
            <div class="comment-likes">
            	<b>Likes</b>: <span class="comment-likes-count"><?= Html::encode($comment['like']) ?></span><br/>
            	<div class="btn btn-default btn-like-comment">Like</div>
            	<div class="btn btn-default btn-dislike-comment">Displike</div><br/>
            	<a href="#" class="comment-other-comment-btn">Комментировать</a>
            </div>
            <? 
            	if($comment['comments']) {
            		echo $this->render('comments', [
            			'comments' => $comment['comments']
            		]); 
            	}
            ?>
        </div>
<? endforeach; ?>