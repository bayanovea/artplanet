<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Comments".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $comment_id
 * @property integer $date
 * @property string $content
 * @property integer $like
 *
 * @property Posts $post
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'comment_id', 'date', 'content', 'like'], 'required'],
            [['post_id', 'comment_id', 'date', 'like'], 'integer'],
            [['content'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'comment_id' => 'Comment ID',
            'date' => 'Date',
            'content' => 'Content',
            'like' => 'Like',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    public function getCommentsByPostId($postId)
    {
        $postId = mysql_real_escape_string($postId);
        $commentsArray = Comments::find()
            ->where(['post_id' => $postId])
            ->asArray()
            ->indexBy('id')
            ->all();

        return $this->structureComments($commentsArray);
    }

    public function structureComments($commentsArray)
    {
        foreach(array_reverse($commentsArray) as $id=>$comment) {
            if($comment['comment_id']) {
                $commentsArray[$comment['comment_id']]['comments'][$comment['id']] = $commentsArray[$comment['id']];
                unset($commentsArray[$comment['id']]);
            }
        }

        return $commentsArray;
    }

    public function likeComment($commentId)
    {
        $commentId = mysql_real_escape_string($commentId);
        $comment = Comments::findOne($commentId);
        return $comment->updateCounters(['like' => 1]);
    }

    public function dislikeComment($commentId)
    {
        $commentId = mysql_real_escape_string($commentId);
        $comment = Comments::findOne($commentId);
        return $comment->updateCounters(['like' => -1]);
    }

    public function addComment($comments, $postId, $parentId, $content)
    {
        $comments->post_id = mysql_real_escape_string($postId);
        $comments->comment_id = mysql_real_escape_string($parentId);
        $comments->date = strval(time());
        $comments->content = mysql_real_escape_string($content);
        $comments->like = 0;

        $result = $comments->save();
        return $result;
    }
}
