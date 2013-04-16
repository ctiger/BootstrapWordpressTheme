    <?php
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
	echo '<p class="nocomments">'.__('This post is password protected. Enter the password to view comments.','templatelite').'</p>';
	return;
}

if ( have_comments() ) :
?>
	<!--<div id="comments_title"><?php /*comments_number(__('Никто не комментировал','templatelite'), __('Один комментарий','templatelite'), __('% коммент.','templatelite'));*/?></div>-->
	<ol class="commentlist">
<?php 
		wp_list_comments(array( 'callback' => 'templatelite_comment' ));
?>
	</ol>
<?php
	if (get_option('page_comments') && get_comment_pages_count() > 1 ) :
		$comment_pages = paginate_comments_links('echo=0');
		if($comment_pages):
			echo '<div class="commentnavi"><span class="commentpages">'.$comment_pages.'</span></div>';
		endif;
	endif;
else : // if($comments)====this is displayed if there are no comments so far
	if ('open' == $post-> comment_status) :
		//If comments are open, but there are no comments.
	else : //got comments but now comments are closed
?>
		<p class="nocomments"><?php _e('Без комментариев.','templatelite');?></p>
<?php 
	endif;
endif;
$args=array(
	"title_reply_to"=>__('Ответить на комментарий','templatelite'),
	"label_submit"=>__( 'Отправить комментарий','templatelite'),
);
comment_form($args); 
?>
