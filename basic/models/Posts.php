<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "Posts".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property string $content
 * @property integer $like
 *
 * @property Comments[] $comments
 */
class Posts extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'name', 'content', 'like'], 'required'],
            [['content'], 'string'],
            [['like'], 'integer'],
            [['date'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'name' => 'Name',
            'content' => 'Content',
            'like' => 'Like',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasOne(Comments::className(), ['post_id' => 'id']);
    }

    /**
     * Get all posts with information about likes
     * @return Array
     */
    public function getAllPosts()
    {
        $posts = Posts::find()
            ->select('
                Posts.id, 
                Posts.date, 
                Posts.name, 
                Posts.content,
                COUNT(Comments.id) AS comments_count,
                SUM(Comments.like) + Posts.`like` AS general_likes'
            )
            ->from('Posts')
            ->joinWith('comments')
            ->groupBy('Posts.id')
            ->orderBy('Posts.date DESC')
            ->asArray()
            ->all();

        return $posts;
    }

    public function getPostById($id)
    {
        $id = mysql_real_escape_string($id);

        return Posts::find()
            ->select('
                Posts.id, 
                Posts.date, 
                Posts.name, 
                Posts.content,
                SUM(Comments.like) + Posts.`like` AS general_likes'
            )
            ->from('Posts')
            ->joinWith('comments')
            ->groupBy('Posts.id')
            ->orderBy('Posts.date DESC')
            ->asArray()
            ->one();
    }

    public function addPost($posts, $name, $content)
    {
        $posts->like = 0;
        $posts->name = mysql_real_escape_string($name);
        $posts->content = mysql_real_escape_string($content);
        $posts->date = strval(time());

        return $posts->save();
    }

    public function deletePost($posts, $comments, $postId)
    {
        $comments->deleteAll('post_id = :postId', Array('postId' => $postId));
        return Posts::findOne($postId)->delete();
    }

    public function likePost($postId)
    {
        $postId = mysql_real_escape_string($postId);
        $post = Posts::findOne($postId);
        return $post->updateAllCounters(['like' => 1]);
    }

    public function dislikePost($postId)
    {
        $postId = mysql_real_escape_string($postId);
        $post = Posts::findOne($postId);
        return $post->updateAllCounters(['like' => -1]);
    }
}
