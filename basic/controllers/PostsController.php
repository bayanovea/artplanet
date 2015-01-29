<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\Posts;
use app\models\PostForm;
use app\models\Comments;

class PostsController extends Controller
{
	public function actionIndex()
    {
    	$posts = new Posts();
    	$allPosts = $posts->getAllPosts();

    	$postForm = new PostForm();
       
        return $this->render('index', [
        	'postForm' => $postForm,
        	'posts' => $allPosts
        ]);
    }

    public function actionDetail()
    {   
        $posts = new Posts();
        $postId = Yii::$app->request->get('post_id');
        $post = $posts->getPostById($postId);

        $comments = new Comments();
        $allComments = $comments->getCommentsByPostId($postId);

        return $this->render('detail', [
            'post' => $post,
            'comments' => $allComments
        ]);
    }

    public function actionAjax()
    {   
        $posts = new Posts();
        $comments = new Comments();

        switch ($_REQUEST['type']) {
            
            /* Add new post */
            case 'add-post':
                $data = $_POST['PostForm'];
                echo $posts->addPost($posts, $data['name'], $data['content']);
                break;

            /* Delete post */
            case 'delete-post':
                $postId = mysql_real_escape_string($_POST['id']);
                $result = $posts->deletePost($posts, $comments, $postId);                
                echo $result;
                break;

            /* Like post */
            case 'like-post':
                $postId = mysql_real_escape_string($_POST['id']);
                $result = $posts->likePost($postId);                
                echo $result;
                break;

             /* Disike post */
            case 'dislike-post':
                $postId = mysql_real_escape_string($_POST['id']);
                $result = $posts->dislikePost($postId);                
                echo $result;
                break;

            default:
                break;
        }
    }
}