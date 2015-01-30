$(document).ready(function(){
		
	/* Showing add post form */
	$('.show-add-form').on('click', function(){
		$(this).hide();
		$('#add-post-form').show();
	});

	/* Add new post */
    $('#add-post-form').submit(function() {
    	var data = $(this).serialize() + "&type=add-post";
       
    	$.ajax({
    		type: 'POST',
    		url: postAjaxUrl,
    		data: data,
    		success: function(data) {
    			if(data) {
                    alert('Пост удачно добавлен');
                    location.reload();
                }
    		},
    		error: function(data) {
    			alert("Ошибка добавления нового поста");
    		}
    	});

        return false;
    }); 

    /* Delete post */
    $('.delete-post').on('click', function(){
        var _this = $(this);
        var id = _this.parents('.posts-list').attr("data-item");

        $.ajax({
            type: 'POST',
            url: postAjaxUrl,
            data: {
                id: id,
                type: 'delete-post'
            },
            success: function(data) {
                if(data) {
                    _this.parents('.posts-list').hide('800');
                }
            },
            error: function(data) {
                alert("Ошибка удаления");
            }
        });

        return false;
    });

    /* Like post */
    $('.btn-like-post').on('click', function(){
        var _this = $(this);
        if(_this.hasClass('active'))
            return false;

        var posts_list = _this.parents('.posts-list');
        var id = posts_list.attr('data-item');
        var likes_num = posts_list.find('.posts-list-likes-num');
        var btn_dislike = posts_list.find('.btn-dislike-post');

        $.ajax({
            type: 'POST',
            url: postAjaxUrl,
            data: {
                id: id,
                type: 'like-post'
            },
            success: function(data) {
                if(data) {
                    _this.addClass('active');
                    btn_dislike.addClass('active');
                    likes_num.text( parseInt(likes_num.text()) + 1 );
                }
            },
            error: function(data) {
                alert("Ошибка при действии Like");
            }
        });

        return false;
    });

    /* Dislike post */
    $('.btn-dislike-post').on('click', function(){
        var _this = $(this);
        if(_this.hasClass('active'))
            return false;

        var posts_list = _this.parents('.posts-list');
        var id = posts_list.attr('data-item');
        var likes_num = posts_list.find('.posts-list-likes-num');
        var btn_like = posts_list.find('.btn-like-post');

        $.ajax({
            type: 'POST',
            url: postAjaxUrl,
            data: {
                id: id,
                type: 'dislike-post'
            },
            success: function(data) {
                if(data) {
                    _this.addClass('active');
                    btn_like.addClass('active');
                    likes_num.text( parseInt(likes_num.text()) - 1 );
                }
            },
            error: function(data) {
                alert("Ошибка при действии Dislike");
            }
        });

        return false;
    });

    /* Like comment */
    $('.btn-like-comment').on('click', function(){
        var _this = $(this);
        if(_this.hasClass('active'))
            return false;

        var comment_likes = _this.parent('.comment-likes');
        var post_comment = comment_likes.parent('.post-comment');
        var id = post_comment.attr('data-item');
        var likes_num = _this.siblings('.comment-likes-count');
        var post_like_count = $('.post-like-count');
        var btn_dislike = _this.siblings('.btn-dislike-comment');

        $.ajax({
            type: 'POST',
            url: postAjaxUrl,
            data: {
                id: id,
                type: 'like-comment'
            },
            success: function(data) {
                if(data) {
                    console.log(data);
                    _this.addClass('active');
                    btn_dislike.addClass('active');
                    likes_num.text( parseInt(likes_num.text()) + 1 );
                    post_like_count.text( parseInt(post_like_count.text()) + 1 );
                }
            },
            error: function(data) {
                alert("Ошибка при действии Like");
            }
        });

        return false;
    });

    /* Dislike comment */
    $('.btn-dislike-comment').on('click', function(){
        var _this = $(this);
        if(_this.hasClass('active'))
            return false;

        var comment_likes = _this.parent('.comment-likes');
        var post_comment = comment_likes.parent('.post-comment');
        var id = post_comment.attr('data-item');
        var likes_num = _this.siblings('.comment-likes-count');
        var post_like_count = $('.post-like-count');
        var btn_like = _this.siblings('.btn-like-comment');

        $.ajax({
            type: 'POST',
            url: postAjaxUrl,
            data: {
                id: id,
                type: 'dislike-comment'
            },
            success: function(data) {
                if(data) {
                    _this.addClass('active');
                    btn_like.addClass('active');
                    likes_num.text( parseInt(likes_num.text()) - 1 );
                    post_like_count.text( parseInt(post_like_count.text()) - 1 );
                }
            },
            error: function(data) {
                alert("Ошибка при действии Dislike");
            }
        });

        return false;
    });
    
    /* Comment other comment */
    $('.comment-other-comment-btn').on('click', function(){
        var _this = $(this);
        var post_comment = _this.parents('.post-comment');
        var id = post_comment.first().attr('data-item');
        var date = post_comment.children('.comment-date');
        var content = post_comment.children('.comment-content');

        $('.other-comment-block').attr('data-item', id);
        $('.other-comment').html( '<p class="comment-date">' + date.html() + '</p><p class="comment-content">' + content.html() + '</p>' );
        $('.other-comment-block').show();

        $.scrollTo('#add-comment', 800);

        return false;
    });

    /* Close other comment */
    $('.close-other-comment').on('click', function(){
        var other_comment_block = $('.other-comment-block');
        other_comment_block.hide(400);
        other_comment_block.attr('data-item', 0);
    });

    /* Add new comment */
    $('#add-comment-form').submit(function() {
        var parent_id = $('.other-comment-block').attr('data-item');
        var uri = window.location.href;
        var post_id = uri.split('/');
        post_id = parseInt(post_id[post_id.length - 1]);
        var data = $(this).serialize() + "&post_id=" + post_id + "&parent_id=" + parent_id + "&type=add-comment";

        $.ajax({
            type: 'POST',
            url: postAjaxUrl,
            data: data,
            success: function(data) {
                if(data) {
                    $('#add-comment').hide();
                    var new_comment = '<div class="post-comment new" data-item="'+parent_id+'">' + 
                        '<p class="comment-date">Только что</p>' + 
                        '<p class="comment-content">' + $('#commentform-content').val() + '</p>' + 
                        '<div class="comment-likes">' + 
                            '<b>Likes</b>: <span class="comment-likes-count">0</span><br>' + 
                            '<div class="btn btn-default btn-like-comment">Like</div>' + 
                            '<div class="btn btn-default btn-dislike-comment">Displike</div><br>' + 
                            '<a href="#" class="comment-other-comment-btn">Комментировать</a>' + 
                        '</div>' +
                    '</div>';

                    if(parent_id == 0)
                        $(new_comment).appendTo( "#post-comments" );
                    else
                        $(new_comment).appendTo('.post-comment[data-item="'+parent_id+'"]');

                    $.scrollTo('.post-comment[data-item="'+parent_id+'"]', '400');
                }
            },
            error: function(data) {
                alert("Ошибка добавления нового комментария");
            }
        });

        return false;
    }); 

});