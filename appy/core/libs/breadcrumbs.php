<?php

/* -------------------------------------------------------------------------------
 * Breadcrumbs on pages
 *
 * Generates breadcrumbs for all pages except home page.
  ------------------------------------------------------------------------------- */
if ( !function_exists( 'wpbucket_breadcrumbs' ) ) {

    function wpbucket_breadcrumbs() {
        global $post, $wpbucket_theme_config;
        $pre_breadcrumbs_li = '';
        $pre_breadcrumbs_before = '';

        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        //.$delimiter = '<span> / </span>'; // delimiter between crumbs
        $home = esc_html__( 'Home', 'appy' ); // text for the 'Home' link
        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $before = '<span class="active">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb
        $pre_breadcrumbs = wp_kses( wpbucket_return_theme_option( 'breadcrumbs_prefix' ), $wpbucket_theme_config['allowed_html_tags'] );
        $breadcrumbs_length = wpbucket_return_theme_option( 'breadcrumbs_length', '', 25 );
        $homeLink = esc_url( home_url( '/' ) );
        $home_html = "<li><a href='{$homeLink}' class='home'>{$home}</a></li>";
        $pre_text_position = 'li'; // position of pre-text like You are here. Options: li/before
        //WRAPPER
        $wrapper_class = 'breadcrumb-container';
        $wrapper_start = ''; // example: '<div class="' . $wrapper_class . '">'
        $wrapper_end = ''; // example: '</div>'
        $menu_name = 'primary';

        $blog_id = get_option( 'page_for_posts', true );
        if ( get_option( 'page_for_posts', true ) ) {
            $blog_page_title = get_the_title( get_option( 'page_for_posts', true ) );
            $blog_page_url = get_permalink( $blog_id );
            $blog_page_link = "<li><a href='{$blog_page_url}'>{$blog_page_title}</a> </li>";
        } else {
            $blog_page_link = '';
        }
        if($pre_breadcrumbs != ''){
             if ( $pre_text_position == 'li' ) {
                $pre_breadcrumbs_li = '<li>' . $pre_breadcrumbs . '</li>';
            } else if ( $pre_text_position == 'before' ) {
                $pre_breadcrumbs_before = '<span>' . $pre_breadcrumbs . '</span>';
            }
        }else{
            $pre_breadcrumbs_li = '';
        }
       

        // filter menu name
        $menu_name = apply_filters( 'wpbucket_main_menu_location', $menu_name );

        if ( is_front_page() ) {
            if ( $showOnHome == 1 ) {
                $html_start = $wrapper_start . $pre_breadcrumbs_before . '<ul class="breadcrumb">' . $pre_breadcrumbs_li . ' ' . $home_html . '</ul>' . $wrapper_end;
                echo wp_kses_post( $html_start );
            }
        } elseif ( is_home() ) {
            $blog_page_title = get_the_title( get_option( 'page_for_posts', true ) );
            $html_start = $wrapper_start . $pre_breadcrumbs_before . '<ul class="breadcrumb">' . $pre_breadcrumbs_li . '' . $home_html . '<li class="active">' . $blog_page_title . '</li></ul>' . $wrapper_end;
            echo wp_kses_post( $html_start );
        } else {

            $html_start = $wrapper_start . $pre_breadcrumbs_before . '<ul class="breadcrumb">' . $pre_breadcrumbs_li . '' . $home_html;
            echo wp_kses_post( $html_start );

            if ( is_category() ) {
                $thisCat = get_category( get_query_var( 'cat' ), false );
                if ( $thisCat->parent != 0 )
                    echo get_category_parents( $thisCat->parent, TRUE, ' ' );
                echo wp_kses_post( $blog_page_link );
                echo '<li class="active">' . esc_html__( 'Category:', 'appy' ) . ' "' . single_cat_title( '', false ) . '"</li>';
            } elseif ( is_search() ) {
                echo '<li class="active">'  . esc_html__( 'Search results:', 'appy' ) . ' "' . get_search_query() . '"</li>';
            } elseif ( is_day() ) {
                echo wp_kses_post( $blog_page_link );
                echo '<li><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li> ';
                echo '<li><a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a> </li> ';
                echo '<li class="active">' . get_the_time( 'd' ) . '</li>';
            } elseif ( is_month() ) {
                echo wp_kses_post( $blog_page_link );
                echo '<li><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li> ';
                echo '<li class="active">' . get_the_time( 'F' ) . '</li>';
            } elseif ( is_year() ) {
                echo wp_kses_post( $blog_page_link );
                echo '<li class="active">' . get_the_time( 'Y' ) . '</li>';
            } elseif ( is_single() && !is_attachment() ) {
                if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object( get_post_type() );
                    $slug = $post_type->rewrite;
                    if ( $post_type->name == 'pi_portfolio' ) {
                        // Get Product page ID from Theme options
                        $portfolio_page = wpbucket_return_theme_option( 'portfolio_page' );
                        $portfolio_page_id = !empty( $portfolio_page ) ? $portfolio_page : '';
                        if ( !empty( $portfolio_page_id ) ) {
                            $page_name = get_the_title( $portfolio_page_id );
                            $page_url = get_permalink( $portfolio_page_id );
                            $page_name = wpbucket_substr( $page_name, $breadcrumbs_length, 3 );
                            echo "<li><a href='{$page_url}'>{$page_name}</a> </li>";
                        }

                        if ( $showCurrent == 1 )
                            echo ' <li class="active">' . get_the_title()  . '</li>';
                    } else {
                        $post_type = get_post_type_object( get_post_type() );
                        $title = wpbucket_substr( $post_type->labels->singular_name, $breadcrumbs_length, 3 );
                        echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/" title="' . $home . '">' . $title . '</a></li>';
                        if ( $showCurrent == 1 ) {
                            $title = wpbucket_substr( get_the_title(), $breadcrumbs_length, 3 );
                            echo ' <li class="active">'  . $title  . '</li>';
                        }
                    }
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents( $cat, TRUE, ' ');
                    if ( $showCurrent == 0 )
                        $cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
                    echo wp_kses_post( $blog_page_link );
                    echo '<li>' . $cats . '</li>';
                    if ( $showCurrent == 1 ) {
                        $title = wpbucket_substr( get_the_title(), $breadcrumbs_length, 3 );
                        echo '<li class="active">'  . $title . '</li>';
                    }
                }
            } elseif ( is_tax() ) {
                $taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );
                $post_type = $taxonomy->object_type[0];
                $post_type_object = get_post_type_object( $post_type );
                $post_type_title = $post_type_object->label;
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $page_url = "";

                if ( $post_type == 'pi_portfolio' ) {
                    // Get Product page ID from Theme options
                    $portfolio_page = wpbucket_return_theme_option( 'portfolio_page' );
                    $portfolio_page_id = !empty( $portfolio_page ) ? $portfolio_page : false;
                    if ( !empty( $portfolio_page_id ) ) {
                        $page_name = get_the_title( $portfolio_page_id );
                        $page_name = wpbucket_substr( $page_name, $breadcrumbs_length, 3 );
                        $page_url = get_permalink( $portfolio_page_id );
                        echo "<li><a href='{$page_url}'>{$page_name}</a> </li>";
                    }
                }
                echo "<li class='active'>{$term->name}</li>";
            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                $post_type = get_post_type_object( get_post_type() );
                $title = wpbucket_substr( $post_type->labels->singular_name, $breadcrumbs_length, 3 );
                echo '<li class="active">' . $title . '</li>';
            } elseif ( is_attachment() ) {

                $parent = get_post( $post->post_parent );

                if ( !empty( $parent ) ) {
                    $parent_title = wpbucket_substr( $parent->post_title, $breadcrumbs_length, 3 );
                    echo '<li><a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent_title . '</a></li>';
                    if ( $showCurrent == 1 ) {
                        $att_title = substr( get_the_title(), 0, $breadcrumbs_length );
                        echo ' <li class="active">' . $att_title . '</li>';
                    }
                }
            } elseif ( is_page() && !$post->post_parent ) {
                if ( wpbucket_return_theme_option( 'breadcrumbs_navigation_label' ) == '1' ) {
                    $menu_id = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_items( $menu_id[$menu_name], array(
                        'posts_per_page' => -1,
                        'meta_key' => '_menu_item_object_id',
                        'meta_value' => $post->ID // the currently displayed post
                            ) );
                    if ( !empty( $menu[0]->title ) ) {
                        $vlc_page_title = $menu[0]->title;
                    } else {
                        $vlc_page_title = get_the_title();
                    }
                } else {
                    $vlc_page_title = get_the_title();
                }
                $vlc_page_title = wpbucket_substr( $vlc_page_title, $breadcrumbs_length, 3 );

                if ( $showCurrent == 1 )
                    echo '<li class="active">' . $vlc_page_title . '</li>';
            } elseif ( is_page() && $post->post_parent ) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                $navigation_label = wpbucket_return_theme_option( 'breadcrumbs_navigation_label' );
                $menu_id = get_nav_menu_locations();
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    if ( $navigation_label == '1' ) {
                        $menu = wp_get_nav_menu_items( $menu_id[$menu_name], array(
                            'posts_per_page' => -1,
                            'meta_key' => '_menu_item_object_id',
                            'meta_value' => $page->ID // the currently displayed page
                                ) );

                        if ( !empty( $menu ) ) {
                            $title = wpbucket_substr( $menu[0]->title, $breadcrumbs_length, 3 );
                            $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . $title . '</a>';
                        } else {
                            $title = wpbucket_substr( get_the_title( $page->ID ), $breadcrumbs_length, 3 );
                            $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . $title . '</a>';
                        }
                    } else {
                        $title = wpbucket_substr( get_the_title( $page->ID ), $breadcrumbs_length, 3 );
                        $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . $title . '</a>';
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse( $breadcrumbs );
                for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
                    if ( $i != count( $breadcrumbs ) - 1 ) {
                        echo '<li>' . $breadcrumbs[$i] .  '</li>';
                    } else {
                        echo '<li>' . $breadcrumbs[$i] . '</li>';
                    }
                }
                if ( $navigation_label == '1' ) {
                    $menu = wp_get_nav_menu_items( $menu_id[$menu_name], array(
                        'posts_per_page' => -1,
                        'meta_key' => '_menu_item_object_id',
                        'meta_value' => $post->ID // the currently displayed post
                            ) );
                    if ( $showCurrent == 1 && !empty( $menu ) ) {
                        $title = wpbucket_substr( $menu[0]->title, $breadcrumbs_length, 3 );
                        echo ' <li class="active">' . $title  . '</li>';
                    } else {
                        $title = wpbucket_substr( get_the_title(), $breadcrumbs_length, 3 );
                        echo ' <li class="active"> ' . $title . '</li>';
                    }
                } else {
                    if ( $showCurrent == 1 ) {
                        $title = wpbucket_substr( get_the_title(), $breadcrumbs_length, 3 );
                        echo ' <li class="active"> ' . $title . '</li>';
                    }
                }
            } elseif ( is_tag() ) {
                echo '<li class="active">' . esc_html__( 'Tag:', 'appy' ) . ' "' . single_tag_title( '', false ) . '" </li>';
            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );
                echo wp_kses_post( $blog_page_link );
                echo '<li class="active">' . esc_html__( 'Author: ', 'appy' ) . esc_html( $userdata->display_name ) . '</li>';
            } elseif ( is_404() ) {
                echo '<li class="active">' . esc_html__( 'Error 404', 'appy' ) . '</li>';
            }

            if ( get_query_var( 'paged' ) ) {
                echo '<li> ' . esc_html__( 'Page', 'appy' ) . ' ' . get_query_var( 'paged' ) . '</li>';
            }

            echo '</ul>' . $wrapper_end;
        }
    }

}

