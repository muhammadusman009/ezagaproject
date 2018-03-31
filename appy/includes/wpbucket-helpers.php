<?php

/*
 * ---------------------------------------------------------
 * Helpers
 *
 * Class for helper functions
 * ----------------------------------------------------------
 */

class Wpbucket_Helpers {
    /*
     * Return Image Sizes
     * parameter $name_thumbnail
     *
     */

    static function wpbucket_get_theme_related_image_sizes( $name_thubnail ) {

        switch ( $name_thubnail ) {
            
            case 'wpbucket_team_tab_thumb':
                $img_height = 195;
                $img_width = 205;
                break;

            case 'wpbucket_team_tab':
                $img_height = 235;
                $img_width = 456;
                break;


            case 'blog_img' :
                $img_width = 371;
                $img_height = 265;
                break;
            case 'blog_single':
                $img_height = 390;
                $img_width = 750;
                break;
            case 'blog_thumb':
                $img_height = 65;
                $img_width = 55;
                break;
            case 'service_img':
                $img_height = 285;
                $img_width = 370;
                break;
            case 'wpbucket_project':
                $img_height = 240;
                $img_width = 270;
                break;
            case 'wpbucket_team':
                $img_height = 426;
                $img_width = 370;
                break;
        }

        return array(
            'width' => $img_width,
            'height' => $img_height
        );
    }

    /*
     * Return Image Url
     * Parameter $post_id
     *
     */

    static function wpbucket_get_image_url( $post_id ) {
        $thumbnail = get_post_thumbnail_id( $post_id );
        $image_url = wp_get_attachment_url( $thumbnail, 'full' );

        return $image_url;
    }
    /*
       * Return Number of comments
       * Parameter $post_id
       *
       */
    static function wpbucket_get_comments_number($postid, $link=false){
        $num_comments = get_comments_number($postid); // get_comments_number returns only a numeric value

        if ( comments_open() ) {
            if ( $num_comments == 0 ) {
                $comments = __('No Comments','appy');
            } elseif ( $num_comments > 1 ) {
                $comments = $num_comments . __(' Comments','appy');
            } else {
                $comments = __('1 Comment','appy');
            }
            if($link){
                $write_comments = $comments;
            }else{
                $write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
            }

        } else {
            $write_comments =  __('Comments are off for this post.','appy');
        }

        return $write_comments;
    }
}
