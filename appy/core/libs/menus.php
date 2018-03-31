<?php

/* ---------------------------------------------------------
 * Menu Walker
 *
 * Custom Menu Walker with addition of icons.
  ---------------------------------------------------------- */
if (!class_exists('Wpbucket_Theme_Menu_Walker')) {


    class Wpbucket_Theme_Menu_Walker extends Walker_Nav_Menu
    {

        /**
         * Starts the list before the elements are added.
         *
         * @see Walker::start_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of arguments. @see wp_nav_menu()
         */
        function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            if ($depth > 0) {
                $depth_level = "depth-" . $depth;
                $output .= "\n$indent<ul class=\"dropdown-menu {$depth_level}\">\n";
            } else {
                $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
            }
        }

        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of arguments. @see wp_nav_menu()
         * @param int $id Current item ID.
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            global $wp_query, $wpbucket_theme_config;

            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            $class_names = $value = '';
            
            $classes = empty($item->classes) ? array() : ( array )$item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = ($args->has_children) ? 'dropdown submenu' : '';
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            if (strpos ( $class_names, 'menu-item-has-children' ) !== false) {
                $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
                $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
                $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
                $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
                $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
                $attributes .= 'data-toggle="dropdown"';
                $attributes .= 'class="dropdown-toggle"';
            } else {
                $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
                $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
                $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
                $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            }

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('wpbucket_theme_menu_icon', $item) . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

            if (isset($wpbucket_theme_config['menu_caret']) && $wpbucket_theme_config['menu_caret'] == '1') {
                $item_output .= ($args->has_children) ? '<span class="caret"></span>' : "";
            }

            $item_output .= '</a>';

            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        /**
         * Add has_children parameter for each menu item.
         *
         * @param object $element
         * @param array $children_elements
         * @param int $max_depth
         * @param int $depth
         * @param array $args
         * @param string $output
         * @return type
         */
        function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
        {
            $id_field = $this->db_fields['id'];
            if (is_object($args[0])) {
                $args[0]->has_children = !empty($children_elements[$element->$id_field]);
            }
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

    }

}

/* ---------------------------------------------------------
 * Responsive Menu Walker
 *
 * Custom Responsive Menu Walker.
  ---------------------------------------------------------- */
if (!class_exists('Wpbucket_Theme_Footer_Menu_Walker')) {

    class Wpbucket_Theme_Footer_Menu_Walker extends Walker_Nav_Menu
    {

        /**
         * Starts the list before the elements are added.
         *
         * @see Walker::start_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of arguments. @see wp_nav_menu()
         */
        function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"submenu\">\n";
        }

        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of arguments. @see wp_nav_menu()
         * @param int $id Current item ID.
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            global $wp_query;

            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : ( array )$item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('wpbucket_theme_menu_icon', $item) . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= ($depth == 0) ? '<span>' . $item->description . '</span>' : "";
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

}

/* ------------------------------------------------------------------
 * Add menu icon to first level menu items.
  ------------------------------------------------------------------- */
if (!function_exists('wpbucket_add_menu_icon')) {

    function wpbucket_add_menu_icon($item)
    {

        // find selected icons from Theme options and set for each menu item
        if ($item->post_type == 'nav_menu_item' && $item->menu_item_parent == 0) {

            // get icons from theme options
            $menu_icons = wpbucket_return_theme_option('menu_icons');

            // if icons is set, add span element before menu item text
            if (!empty($menu_icons[$item->ID])) {
                $menu_icon = "<span class='nav-icon {$menu_icons[$item->ID]}'></span>";
            } else {
                $menu_icon = '';
            }

            return $menu_icon;
        }
    }

}

add_filter('wpbucket_theme_menu_icon', 'wpbucket_add_menu_icon');
