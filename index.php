<?php
/*
Plugin Name: Recent Comments Widget
Plugin URI: 
Description: A comments post widget with extra functions that allow admin to make changes to certain values
Version: 1.0
Author URI: @loverajoel
*/

class recentcomments extends WP_Widget {

    public function __construct() {
        parent::WP_Widget(false, 'Recent Comments Widget',
            array(
                'description' => __('A comments post widget with extra functions that allow admin to make changes to certain values') 
                )
            );
        ;
    }

    public function widget( $args, $inst ) {

        extract( $args );

        $title = $inst['title'];
        $number = $inst['number'];

        echo $before_widget;

        echo "<h2>$title</h2>";

        $args = array(
            'number' => $number,
            );
        $comments = get_comments($args);

        echo "<ul>";
        foreach($comments as $comment) :
            echo "<li>";
            echo "<div><div class='pic'>".get_avatar( $comment, 42 )."</div><span><a href='".get_permalink($comment->comment_post_ID)."'>".get_the_title($comment->comment_post_ID)."</a></span><span>by: ".$comment->comment_author."</span></div>";
            echo "</li>";
        endforeach;
        echo "</ul>";
        echo $after_widget;

    }

    public function update( $new_inst, $old_inst ) {
        $inst = array();
        $inst['title'] = ( $new_inst['title'] );
        $inst['number'] = ( $new_inst['number'] );
        return $inst;
    }


    public function form( $inst ) {

        $title = $inst[ 'title' ];
        $number = $inst[ 'number' ];

        ?>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
            <?php _e( 'title:' ); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        <label for="<?php echo $this->get_field_id( 'number' ); ?>">    
            <?php _e( 'Number of comments:' ); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
<?php 
}
}

add_action( 'widgets_init', create_function('', 'return register_widget("recentcomments");') );

?>