<?php
/**
 * Search Template
 *
 *
 * @file           search.php
 * @package        Bootstrap Parallax
 * @author         Brad Williams
 * @copyright      2011 - 2013 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.1
 * @link           http://codex.wordpress.org/Theme_Development#Search_Results_.28search.php.29
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
        <div class="span9">

        <div id="content">
            <h6><?php _e('We found','responsive'); ?>
			<?php
                $allsearch = &new WP_Query("s=$s&showposts=-1");
                $key = esc_html($s, 1);
                $count = $allsearch->post_count;
                _e(' &#8211; ', 'responsive');
                echo $count . ' ';
                _e('articles for ', 'responsive');
                _e('<span class="post-search-terms">', 'responsive');
                echo $key;
                _e('</span><!-- end of .post-search-terms -->', 'responsive');
                wp_reset_query();
            ?>
            </h6>


<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
    $title  = get_the_title();
    $keys= explode(" ",$s);
    $title  = preg_replace('/('.implode('|', $keys) .')/iu',
        '<strong class="search-excerpt">\0</strong>',
        $title);
?>
                <h1 class="search-page-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'responsive'), the_title_attribute('echo=0')); ?>"><?php echo $title; ?></a></h1>

                <div class="post-meta">
                <?php
                    printf( __( '<i class="icon-time"></i> %2$s <i class="icon-user"></i> %3$s', 'responsive' ),'meta-prep meta-prep-author',
		            sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			            get_permalink(),
			            esc_attr( get_the_time() ),
			            get_the_date()
		            ),
		            sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			            get_author_posts_url( get_the_author_meta( 'ID' ) ),
			        sprintf( esc_attr__( 'View all posts by %s', 'responsive' ), get_the_author() ),
			            get_the_author()
		                )
			        );
		        ?>
                </div><!-- end of .post-meta -->

                <div class="post-entry">
                    <?php the_content(__('Read more &raquo;', 'responsive')); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div><!-- end of .pagination -->')); ?>
                </div><!-- end of .post-entry -->

                <div class="post-data">
				    <?php the_tags(__('Tagged with:', 'responsive') . ' ', ', ', '<br />'); ?>
					<?php printf(__('Posted in %s', 'responsive'), get_the_category_list(', ')); ?> |
					<?php edit_post_link(__('Edit', 'responsive'), '', ' &#124; '); ?>
					<?php comments_popup_link(__('No Comments <i class="icon-arrow-down"></i>', 'responsive'), __('1 Comment <i class="icon-arrow-down"></i>', 'responsive'), __('% Comments <i class="icon-arrow-down"></i>', 'responsive')); ?>
                </div><!-- end of .post-data -->

            </div><!-- end of #post-<?php the_ID(); ?> -->

			<?php comments_template( '', true ); ?>

        <?php endwhile; ?>

        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
        <div class="navigation">
			<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive' ) ); ?></div>
            <div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive' ) ); ?></div>
		</div><!-- end of .navigation -->
        <?php endif; ?>

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
        <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&#9166; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
        <?php get_search_form(); ?>

<?php endif; ?>

        </div><!-- end of #content -->
    </div>

<?php get_sidebar(); ?>
</div></div></div>
<?php get_footer(); ?>