<?php
/**
 * Search Form Template
 *
 *
 * @file           searchform.php
 * @package        Bootstrap Parallax
 * @author         Brad Williams
 * @copyright      2011 - 2013 Brag Interactive
 * @license        license.txt
 * @version        Release: 2.3.1
 * @link           http://codex.wordpress.org/Function_Reference/get_search_form
 * @since          available since Release 1.0
 */
?>
	<form method="get" class="form-search form-inline" action="<?php echo home_url( '/' ); ?>">
		<div class="input-append">
		<input type="text" class="span2 form-search" name="s" placeholder="<?php esc_attr_e('search here &hellip;', 'responsive'); ?>" />
		<button type="submit" class="btn" name="submit" id="searchsubmit" value="<?php esc_attr_e('Go', 'responsive'); ?>"><i class="icon-search"></i></button>
	</div>
    <br/><br/><br/>
	</form>