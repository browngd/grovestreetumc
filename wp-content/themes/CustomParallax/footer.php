<?php
/**
 * Footer Template
 *
 *
 * @file           footer.php
 * @package        Bootstrap Parallax
 * @author         Brad Williams
 * @copyright      2011 - 2013 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.1
 * @link           http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 * @since          available since Release 1.0
 */
?>
    </div><!-- end of wrapper-->
    <?php responsive_wrapper_end(); // after wrapper hook ?>


 <?php responsive_container_end(); // after container hook ?>
<div class="top-footer">
<h4>Come Discover Jesus Christ At Grove Street United Methodist Church</h4>
</div>
<!-- Section #3 -->
  <section id="footer" data-speed="10" data-type="background">

    <div class="container">
      <div class="row-fluid">

        <div class="span4">
           <?php if (!dynamic_sidebar('footer-widget-1')) : ?>

                <div class="widget-title-footer"><h2><?php _e('Footer Widget 1', 'responsive'); ?></h2></div>
                <div class="textwidget"><?php _e('This is your first footer widget box. To edit please go to Appearance > Widgets','responsive'); ?></div>

            <?php endif;?>
            </div>

            <div class="span4">
           <?php if (!dynamic_sidebar('footer-widget-2')) : ?>

                <div class="widget-title-footer"><h2><?php _e('Footer Widget 2', 'responsive'); ?></h2></div>
                <div class="textwidget"><?php _e('This is your second footer widget box. To edit please go to Appearance > Widgets','responsive'); ?></div>

            <?php endif; ?>
            <br/>
            <?php if (!dynamic_sidebar('footer-widget-3')) : ?>

                <div class="widget-title-footer"><h2><?php _e('Footer Widget 3', 'responsive'); ?></h2></div>
                <div class="textwidget"><?php _e('This is your third footer widget box. To edit please go to Appearance > Widgets','responsive'); ?></div>

            <?php endif; ?>
            </div>

            <div class="span4">
           <?php if (!dynamic_sidebar('footer-widget-4')) : ?>

                <div class="widget-title-footer"><h2><?php _e('Footer Widget 4', 'responsive'); ?></h2></div>
                <div class="textwidget"><?php _e('This is the fourth footer widget box. ','responsive'); ?></div>

            <?php endif; ?>
            </div>
        </div>
      </div>
  </section>
      <div class="sub-footer">
        <div class="container">
<p class="pull-left">© 2013 Grove Street United Methodist Church. All rights reserved. </p>
<p class="pull-right">Designed by <a rel="tooltip" title="Visit to find out how BitCrunched! can help you!" href="http://www.bitcrunched.com"><span style="color: #889D07 !important">Bit</span><span style="color: #FA6801 !important">Crunched!
</div>
</div>
<?php wp_footer(); ?>

<SCRIPT LANGUAGE="JavaScript">
<!-- hide from none JavaScript Browsers

Image1= new Image(2336,1200)
Image1.src = "http://www.grovestreetumc.org/assets/sky-clouds.png"

// End Hiding -->
</SCRIPT>

<!-- Microsoft Translator -->
<div id="MicrosoftTranslatorWidget" style="width: 200px; min-height: 0px; border-color: #3A5770; background-color: #78ADD0; display: none;"><noscript><a href="http://www.microsofttranslator.com/bv.aspx?a=http%3a%2f%2fwww.grovestreetumc.org%2f">Translate this page</a><br />Powered by <a href="http://www.bing.com/translator">Microsoft® Translator</a></noscript></div> <script type="text/javascript"> /* <![CDATA[ */ setTimeout(function() { var s = document.createElement("script"); s.type = "text/javascript"; s.charset = "UTF-8"; s.src = ((location && location.href && location.href.indexOf('https') == 0) ? "https://ssl.microsofttranslator.com" : "http://www.microsofttranslator.com" ) + "/ajax/v2/widget.aspx?mode=auto&widget=none&from=en&layout=ts"; var p = document.getElementsByTagName('head')[0] || document.documentElement; p.insertBefore(s, p.firstChild); }, 0); /* ]]> */ </script>
</body>
</html>