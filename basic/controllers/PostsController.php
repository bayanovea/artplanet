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
use app\models\CommentForm;

class PostsController extends Controller
{
	public function actionIndex()
    {
    	$posts = new Posts();
        $postForm = new PostForm();
    	$allPosts = $posts->getAllPosts();
       
        return $this->render('index', [
        	'posts' => $allPosts,
            'postForm' => $postForm
        ]);
    }

    public function actionDetail()
    {   
        $posts = new Posts();
        $comments = new Comments();
        $commentForm = new CommentForm();

        $postId = Yii::$app->request->get('post_id');
        $post = $posts->getPostById($postId);
        $allComments = $comments->getCommentsByPostId($postId);

        return $this->render('detail', [
            'post' => $post,
            'comments' => $allComments,
            'commentForm' => $commentForm
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
                $result = $posts->likePost($_POST['id']);                
                echo $result;
                break;

             /* Disike post */
            case 'dislike-post':
                $result = $posts->dislikePost($_POST['id']);                
                echo $result;
                break;

            /* Like comment */
            case 'like-comment':
                $result = $comments->likeComment($_POST['id']);                
                echo $result;
                break;

             /* Disike comment */
            case 'dislike-comment':
                $result = $comments->dislikeComment($_POST['id']);                
                echo $result;
                break;

            /* Add comment */
            case 'add-comment':
                $data = $_POST['CommentForm'];
                $result = $comments->addComment($comments, $_POST['post_id'], $_POST['parent_id'], $data['content']);                
                echo $result;
                break;

            default:
                break;
        }
    }

}