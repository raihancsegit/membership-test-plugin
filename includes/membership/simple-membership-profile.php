<?php 
if (is_user_logged_in()) {
$user_id = get_current_user_id();
$user = get_userdata($user_id);
if(isset($_POST['update'])){
    $user_id = esc_sql($_POST['user_id']);
    $fname = esc_sql($_POST['user_fname']);
    $lname = esc_sql($_POST['user_lname']);

    $usermeta = array(
        'ID' => $user_id,
        'first_name' =>$fname,
        'last_name' => $lname,
    );
    $user = wp_update_user($usermeta);
    if(is_wp_error( $user )){
        echo "can not update " . $user->get_error_message();
    }
}
if($user != false){
    $gender = get_user_meta($user_id,'gender');
    $fname = get_user_meta($user_id,'first_name');
    $lname = get_user_meta($user_id,'last_name');
}
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$online_status = get_user_meta($current_user_id, 'online_status', true);
?>
<div class="user-info-and-update">
    <div class="simple-user-info">
        <h5>Hi <?php echo $fname[0] . " ".$lname[0]?></h5>
        <h5>Registration Date: <?php echo $current_user->user_registered; ?></h5>
        <p>
            <?php 
        if ($online_status === 'online') {
            echo '<p>Status: Online</p>';
        } else {
            echo '<p>Status: Offline</p>';
        }
    ?>
        </p>

        <h5><a href="<?php echo wp_logout_url();?>">Logout</a></h5>

    </div>

    <div class="update-info">
        <h3>Update Info</h3>
        <form action="<?php echo get_the_permalink();?>" method="post">
            First Name : <input type="text" name="user_fname" value="<?php echo $fname[0];?>" />
            Last Name : <input type="text" name="user_lname" value="<?php echo $lname[0];?>" />
            <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
            <p style="margin-top: 10px"><input type="submit" value="update" name="update" /></p>
        </form>
    </div>

</div>


<?php
if (isset($_POST['submit-post'])) {
    $post_title = sanitize_text_field($_POST['post-title']);
    $post_content = sanitize_textarea_field($_POST['post-content']);
    
    $post_data = array(
        'post_title'    => $post_title,
        'post_content'  => $post_content,
        'post_author'   => get_current_user_id(),
        'post_status'   => 'publish',
        'post_type'     => 'post'
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        echo '<h4>Post added successfully.</h4>';
    } else {
        echo 'Failed to add post.';
    }
}
?>
<div class="add-post">
    <h3>Add a Post</h3>
    <form id="add-post-form" method="post">
        <label for="post-title">Post Title:</label><br>
        <input type="text" name="post-title" required><br>
        <label for="post-content">Post Description:</label><br>
        <textarea name="post-content" rows="4" required></textarea><br>
        <input type="submit" name="submit-post" value="Add Post">
    </form>
</div>
<?php
if (isset($_POST['delete-post'])) {
    $post_id = $_POST['delete-post-id'];

    if (get_post_field('post_author', $post_id) == get_current_user_id()) {
        wp_delete_post($post_id, true);
        echo '<h4>Post deleted successfully.</h4>';
    } else {
        echo 'You are not authorized to delete this post.';
    }
}

if (isset($_POST['submit-edit'])) {
    $post_id = intval($_POST['edit-post-id']);
    $post_title = sanitize_text_field($_POST['edit-post-title']);
    $post_content = sanitize_textarea_field($_POST['edit-post-content']);

    $post_data = array(
        'ID'            => $post_id,
        'post_title'    => $post_title,
        'post_content'  => $post_content,
    );

    $updated = wp_update_post($post_data);

    if ($updated) {
        echo '<h4>Post updated successfully.</h4>';
    } else {
        echo 'Failed to update post.';
    }
}
?>
<div class="user-posts">
    <h3>Your Posts</h3>
    <?php
    $args = array(
        'author' => get_current_user_id(),
        'post_type' => 'post',
        'posts_per_page' => -1
    );
    $user_posts = new WP_Query($args);

    if ($user_posts->have_posts()) :
        while ($user_posts->have_posts()) : $user_posts->the_post(); ?>
    <div class="user-post">
        <h4><?php the_title(); ?></h4>
        <div class="post-content">
            <p><?php the_content(); ?></p>
        </div>
        <div class="post-actions">
            <button class="edit-post-btn" data-post-id="<?php the_ID(); ?>">Edit</button> <!-- Edit post button -->
            <form method="post" class="delete-post-form" style="display:inline;">
                <input type="hidden" name="delete-post-id" value="<?php echo get_the_ID(); ?>">
                <input type="submit" name="delete-post" value="Delete"
                    onclick="return confirm('Are you sure you want to delete this post?');">
            </form>
        </div>
        <div class="edit-post-form" style="display:none;">
            <form method="post">
                <label for="edit-post-title">Post Title:</label><br>
                <input type="text" name="edit-post-title" value="<?php the_title(); ?>" required><br>
                <label for="edit-post-content">Post Content:</label><br>
                <textarea name="edit-post-content" rows="4"
                    required><?php echo esc_textarea(get_the_content()); ?></textarea><br>
                <input type="hidden" name="edit-post-id" value="<?php the_ID(); ?>">
                <input type="submit" name="submit-edit" value="Update Post">
            </form>
        </div>
        <div class="comments-section">
            <h5>Comments</h5>
            <?php comments_template(); ?>
        </div>

    </div>
    <?php endwhile;
    else :
        echo 'You have no posts yet.';
    endif;

    wp_reset_postdata();
    ?>
</div>

<br />


<?php
}
?>