$(document).ready(function(){
		
	/* Showing add post form */
	$('.show-add-form').on('click', function(){
		$(this).hide();
		$('#add-post-form').show();
	});

	/* Add new post */
    $('#add-post-form').submit(function() {
    	var data = $(this).serialize() + "&type=add-post";

        console.log(data);
       
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
                alert("Ошибка удаления");
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
                alert("Ошибка удаления");
            }
        });

        return false;
    });

});