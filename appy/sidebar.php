<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */
$page_sidebar_id = 'blog-sidebar-id';
if (is_active_sidebar($page_sidebar_id)) :
    dynamic_sidebar($page_sidebar_id);
endif;