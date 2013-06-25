<?php
/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Bootstrap Parallax
 * @author         Brad Williams
 * @copyright      2011 - 2013 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.1
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
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
        <a href="http://www.grovestreetumc.org/imagine-no-malaria"><img src="http://www.grovestreetumc.org/wp-content/uploads/2013/06/hd_01.png" alt="hd_01" width="960" height="172" class="aligncenter size-full wp-image-668 animated fadeIn" style="animation-delay:4s; -webkit-animation-delay:4s;"/></a>
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
                <div id="content-archive">
                    <?php if (have_posts()) : ?>
                    <?php if(of_get_option('breadcrumbs', '1')) {?>
                    <?php echo responsive_breadcrumb_lists(); ?>
                    <?php } ?>
                    <h6>
                        <?php if ( is_day() ) : ?>
                        <?php printf( __( 'Daily Archives: %s', 'responsive' ), '<span>' . get_the_date() . '</span>' ); ?>
                        <?php elseif ( is_month() ) : ?>
                        <?php printf( __( 'Monthly Archives: %s', 'responsive' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
                        <?php elseif ( is_year() ) : ?>
                        <?php printf( __( 'Yearly Archives: %s', 'responsive' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
                        <?php else : ?>
                        <?php _e( 'Blog', 'responsive' ); ?>
                        <?php endif; ?>
                    </h6>
                    <?php while (have_posts()) : the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'responsive'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
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
    				    <?php if ( comments_open() ) : ?>
                            <span class="comments-link">
                            <span class="mdash">&mdash;</span>
                        <?php comments_popup_link(__('No Comments <i class="icon-arrow-down"></i>', 'responsive'), __('1 Comment <i class="icon-arrow-down"></i>', 'responsive'), __('% Comments <i class="icon-arrow-down"></i>', 'responsive')); ?>
                            </span>
                        <?php endif; ?>
                    </div><!-- end of .post-meta -->

                    <div class="post-entry">
                        <?php the_excerpt(); ?>
                         <?php custom_link_pages(array(
                                'before' => '<div class="pagination"><ul>' . __(''),
                                'after' => '</ul></div>',
                                'next_or_number' => 'next_and_number', # activate parameter overloading
                                'nextpagelink' => __('&rarr;'),
                                'previouspagelink' => __('&larr;'),
                                'pagelink' => '%',
                                'echo' => 1 )
                                ); ?>
                    </div><!-- end of .post-entry -->

                    <div class="post-data">
				        <?php the_tags(__('Tagged with:', 'responsive') . ' ', ' ', '<br />'); ?>
                    </div><!-- end of .post-data -->

                    <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div>
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
                </div><!-- end of #content-archive -->
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>





<?php get_footer(); ?>