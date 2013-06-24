<?php
/**
 * Error 404 Template
 *
 *
 * @file           404.php
 * @package        Bootstrap Parallax
 * @author         Brad Williams
 * @copyright      2011 - 2013 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.1
 * @link           http://codex.wordpress.org/Creating_an_Error_404_Page
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>
<div class="page-header-top">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div id="content-full">
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:0px;">
    <div class="banner-content" style="max-width:960px; margin-left:auto; margin-right:auto;">
        <a href="http://www.grovestreetumc.org/imagine-no-malaria"><img src="http://www.grovestreetumc.org/wp-content/uploads/2013/06/hd_01.png" alt="hd_01" width="960" height="172" class="aligncenter size-full wp-image-668 animated fadeInDownBig" style="animation-delay:4s; -webkit-animation-delay:4s;"/></a>
    </div>
</div>
<div class="span12 bible-verse">
    <div class="container align-center">
        <h1>For God loved the world so much that he gave his one and only Son, so that everyone who believes in him will not perish but have eternal life. John 3:16</h1><br/>
        <h1><i class="icon-spinner icon-spin icon-large"></i></h1>
    </div>
</div>
<div class="content-overlay animated fadeInUpBig" style="margin-bottom:40px;">
<div class="container">
<div class="row">
    <div class="span12">
        <div id="content-full">
            <div id="post-0" class="error404">
                <div class="post-entry">
                    <h1 class="title-404"><?php _e('404 &#8212; Whoopsie!', 'responsive'); ?></h1>
                    <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
                    <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&larr; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
                    <?php get_search_form(); ?>
                </div><!-- end of .post-entry -->
            </div><!-- end of #post-0 -->
        </div><!-- end of #content-full -->
    </div>
</div>
</div>
</div></div></div></div>
<?php get_footer(); ?>