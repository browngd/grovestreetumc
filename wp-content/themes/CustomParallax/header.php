<?php
/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Bootstrap Parallax
 * @author         Brad Williams
 * @copyright      2011 - 2013 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.1
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title><?php wp_title('&#124;', true, 'right'); ?><?php bloginfo('name'); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- Standard iPhone -->
<link rel="apple-touch-icon" sizes="57x57" href="<?php get_template_directory_uri();?>/css/images/touch-icon-iphone-114.png" />
<!-- Retina iPhone -->
<link rel="apple-touch-icon" sizes="114x114" href="<?php get_template_directory_uri();?>/css/images/touch-icon-iphone-114.png" />
<!-- Standard iPad -->
<link rel="apple-touch-icon" sizes="72x72" href="<?php get_template_directory_uri();?>/css/images/touch-icon-ipad-144.png" />
<!-- Retina iPad -->
<link rel="apple-touch-icon" sizes="144x144" href="<?php get_template_directory_uri();?>/css/images/touch-icon-ipad-144.png" />

<!--[if IE 7]>
  <link rel="stylesheet" href="<?php get_template_directory_uri();?>/css/font-awesome-ie7.min.css">
<![endif]-->

<?php wp_head(); ?>



</head>

<body <?php body_class(); ?>>

<?php responsive_container(); // before container hook ?>


    <?php responsive_header(); // before header hook ?>
    <div id="header">


    <?php responsive_in_header(); // header hook ?>

	<?php $nav_color = of_get_option('nav_color');?>



    <div style="position:fixed" class="navbar navbar-fixed-top <?php if($nav_color =='inverse') { echo 'navbar-inverse'; } ?>">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

           <?php if ( of_get_option('logo_upload') ) { ?>
            <div id="logo"><a class="tooltips" title="Click for home page" href=" <?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="homepage">
            <img src="<?php echo of_get_option('logo_upload'); ?>" alt="<?php bloginfo( 'name' ) ?>"/>
            </a></div><!-- end of #logo -->
            <?php } else { ?>
            <?php if (is_front_page()) { ?>
            <a class="brand" href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="homepage"><?php bloginfo( 'name' ) ?></a>
            <?php } else { ?>
            <a class="brand" href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="homepage"><?php bloginfo( 'name' ) ?></a>
            <?php } } ?>




          <div class="nav-collapse collapse">

			   <?php

                $args = array(
                    'theme_location' => 'top-bar',
                    'depth'      => 2,
                    'container'  => false,
                    'menu_class'     => 'nav',
                    'walker'     => new Bootstrap_Walker_Nav_Menu()
                );

                wp_nav_menu($args);

            ?>


            <?php if(of_get_option('search_bar', '1')) {?>
                            <form class="navbar-search pull-right" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                                <input name="s" id="s" type="text" class="search-query" placeholder="<?php _e('Search','responsive'); ?>">
                            </form>

                            <?php } ?>



             <?php if(of_get_option('header_social', '1')) {?>

            <?php
            // First let's check if any of this was set

                echo '<div class="social-icons nav pull-right">';

           if (of_get_option('twitter_url')) echo '<a class="tooltips" title="Connect on Twitter" href="' . of_get_option('twitter_url') . '">'
                    .'<i class="icon-twitter-sign"></i>'
                    .'</a>';

                if (of_get_option('fb_url')) echo '<a class="tooltips" title="Connect on Facebook" href="' . of_get_option('fb_url') . '">'
                    .'<i class="icon-facebook-sign"></i>'
                    .'</a>';

                if (of_get_option('pinterest_url')) echo '<a href="' . of_get_option('pinterest_url') . '">'
                    .'<i class="icon-pinterest-sign"></i>'
                    .'</a>';

                if (of_get_option('linkedin_url')) echo '<a href="' . of_get_option('linkedin_url') . '">'
                    .'<i class="icon-linkedin-sign"></i>'
                    .'</a>';

                 if (of_get_option('google_url')) echo '<a class="tooltips" title="Connect on Google+" href="' . of_get_option('google_url') . '">'
                    .'<i class="icon-google-plus-sign"></i>'
                    .'</a>';

                if (of_get_option('github_url')) echo '<a href="' . of_get_option('github_url') . '">'
                    .'<i class="icon-github-sign"></i>'
                    .'</a>';

                if (of_get_option('rss_url')) echo '<a href="' . of_get_option('rss_url') . '">'
                    .'<i class="icon-rss"></i>'
                    .'</a>';

                echo '</div><!-- end of .social-icons -->';
         ?>
          <?php } ?>
          </div>

        </div>
        </div>

 </div>



    </div><!-- end of #header -->
    <?php responsive_header_end(); // after header hook ?>

	<?php responsive_wrapper(); // before wrapper ?>

        <div id="wrapper" class="clearfix">

    <?php responsive_in_wrapper(); // wrapper hook ?>
