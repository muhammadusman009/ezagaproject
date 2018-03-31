<?php
/**
 * Copyright (c) 12/7/2017.
 * Theme Name: Appy
 * Author: pranontheme
 * Website: http://pranontheme.net/
 */

global $wpbucket_theme_config;
?>
<footer class="text-center">
    <?php echo wp_kses( wpbucket_return_theme_option( 'copyright_text' ), $wpbucket_theme_config['allowed_html_tags'] ) ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>