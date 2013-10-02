<?php
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
 
// LOAD IN CHILD THEME TEMPATE FILES
if(defined('CHILD_THEME_NAME') && file_exists(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_header.php") ){
	
	include(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_header.php");
		
}elseif(isset($GLOBALS['CORE_THEME']['template']) && file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template']."/_header.php") ){
		
	include(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template'].'/_header.php');
  		
}else{

global $CORE, $userdata;  
 
// LOAD IN COLUMN LAYOUTS
$CORE->BODYCOLUMNS();

header('X-UA-Compatible: IE=edge,chrome=1');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--[if lte IE 8 ]><html lang="en" class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie"><![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 
<?php wp_head(); ?><?php hook_meta(); /* HOOK */ ?>
</head>
<!-- [WLT] FRAMRWORK // BODY -->
<body <?php $CORE->BODYCLASS(); ?>>
<!-- [WLT] FRAMRWORK // PAGE WRAPPER -->
<div class="<?php $CORE->CSS("container"); ?> page-wrapper" id="<?php echo THEME_TAXONOMY; ?>_styles">
<?php hook_wrapper_before(); /* HOOK */ ?>

<?php
// THIS IS THE CORE HEADER HOOK
function _core_header(){ global $CORE; $_hh = '';
$STRING = '<!-- [WLT] FRAMRWORK // HEADER -->
<header class="row-fluid" id="core_header_wrapper">';

	$NAVBAR = wp_nav_menu( array( 
            'container' => 'div',
            'container_class' => 'nav-collapse collapse',
            'theme_location' => 'top-navbar',
            'menu_class' => 'nav',
			'fallback_cb'     => '',
			'echo'            => false,
            'walker' => new Bootstrap_Walker(),									
            ) );
	if(strlen($NAVBAR) > 0){
	$_hh = '<div id="core_header_navigation" class="hidden-phone"><div class="navbar"><div class="navbar-inner">'.$NAVBAR.'</div></div><div class="clearfix"></div></div>';
	}
	$STRING .= hook_header_navbar($_hh);
    $STRING .= '<div id="core_header"><div class="couponiamge">';
    $STRING .= hook_logo_wrapper('<div class="span5" id="core_logo"><a href="'.get_home_url().'/" title="'.get_bloginfo('name').'">'.hook_logo(true).'</a></div>');
    $STRING .= hook_banner_header_wrapper('<div class="span7 hidden-phone" id="core_banner">'.hook_banner_header($CORE->BANNER('header')).'</div>');            
    $STRING .= '<div class="clearfix"></div>
    </div></div>
</header>';
return $STRING;
}
echo hook_header(_core_header());

echo '<!-- [WLT] FRAMRWORK // END HEADER --><div id="core_body_wrapper">';

// THIS IS THE CORE MENU HOOK
function _core_menu(){ global $CORE;

$STRING = '<!-- [WLT] FRAMRWORK // MENU -->
<div class="row-fluid" id="core_menu_wrapper"> 
<nav class="navbar">
	<div class="navbar-inner">	
		<div class="container">';		    
	$STRING .= wp_nav_menu( array( 
            'container' => 'div',
            'container_class' => 'nav-collapse collapse',
            'theme_location' => 'primary',
            'menu_class' => 'nav',
			'fallback_cb'     => '',
			'echo'            => false,
            'walker' => new Bootstrap_Walker(),									
            ) );  
	/*** include mobile menu ***/
	$STRING .= $CORE->MENU_MOBILE();        
 	$STRING .= '</div>';					              
	$STRING .= '</div></nav> </div>';	
return $STRING;

}
echo wp_nav_menu( array( 'theme_location' => 'middletop-menu', 'container_class' => 'tab-bar1' ) );

echo hook_menu(_core_menu(),1);

hook_container_before(); /* HOOK */ ?> 

  
<!-- [WLT] FRAMRWORK // MAIN BODY -->  
<div class="container-fluid<?php $CORE->CSS("2columns"); ?>" id="core_padding">

<?php 

hook_breadcrumbs_before(); /* HOOK */

// THIS IS THE CORE BREADCRUMBS HOOK
function _core_breadcrumbs(){ global $CORE, $userdata; 
	
	if($GLOBALS['CORE_THEME']['breadcrumbs_home'] == '1'){
	$GLOBALS['show_breadcumbs_home'] = true;
	}
	if(!isset($GLOBALS['flag-home']) || isset($GLOBALS['show_breadcumbs_home']) ){ 	
	$STRING = '<!-- FRAMRWORK // MENU --> 
	<article id="core_main_breadcrumbs_wrapper">
	<ul class="breadcrumb hidden-phone clearfix" id="core_main_breadcrumbs">
	
		<li class="right">';
		if(get_option('users_can_register') == '1' || defined('WLT_DEMOMODE') ){
			if(isset($userdata) && $userdata->ID){
				if(isset($GLOBALS['CORE_THEME']['links'])){
				$STRING .= '
				<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'"><i class="icon-user"></i> '.$CORE->_e(array('head','4')).'</a> <span class="divider">/</span> 
				<a href="'.wp_logout_url().'"><i class="icon-off"></i> '.$CORE->_e(array('account','8')).'</a>';
				}
			}else{
				$STRING .= '<a href="'.get_home_url().'/wp-login.php">
				<i class="icon-user"></i> '.$CORE->_e(array('head','5')).'
				</a> <span class="divider">/</span>		
				<a href="'.get_home_url().'/wp-login.php?action=register">
				<i class="icon-check"></i> '.$CORE->_e(array('head','6')).'</a>';        
			}// end if
		}
	$STRING .= '</li>'.hook_breadcrumbs_func($CORE->BREADCRUMBS()).'</ul></article>';	
 	return $STRING;
	}
} 
echo hook_breadcrumbs(_core_breadcrumbs());

hook_breadcrumbs_after(); /* HOOK */ ?>

<?php 
// CHECK FOR HOME PAGE FLAG
if(isset($GLOBALS['flag-home'])){ echo $CORE->SLIDERS(); }// END HOME PAGE CHECK 
 
hook_slider_after(); /* HOOK */ ?> 

<div id="core_columns_wrapper">

<?php echo $CORE->BANNER('full_top'); ?> 

<?php hook_core_columns_wrapper_inside(); /* HOOK */ ?>

<?php if(!isset($GLOBALS['flag-custom-homepage'])){ ?>

	<?php if(isset($GLOBALS['flag-home']) ){ ?>
    <div id="core_homepage_fullwidth_wrapper"> 
    <?php    // GET HOME PAGE OBJECTS
        if(isset($GLOBALS['CORE_THEME']['homepage']) && isset($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1){
            echo $CORE->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'],$fullwidth=true);
        }
	?>
    </div>
    <?php } ?>
    
    <div class="row-fluid" id="core_columns_inner_wrapper">

	<?php if(!isset($GLOBALS['nosidebar-left'])){ ?>
    <!-- [WLT] FRAMRWORK // LEFT COLUMN -->
	<aside class="<?php $CORE->CSS("columns-left"); ?> <?php if(isset($GLOBALS['CORE_THEME']['mobileview']['sidebars']) && $GLOBALS['CORE_THEME']['mobileview']['sidebars'] == '1'){ ?><?php }else{ ?>hidden-phone<?php } ?>" id="core_left_column">
    
    	<?php hook_core_columns_left_top(); /* HOOK */ ?>
             
    	<?php dynamic_sidebar('Left Column'); ?>
        
        <?php hook_core_columns_left_bottom(); /* HOOK */ ?>
        
    </aside>
    <?php } ?>
    
    <!-- [WLT] FRAMRWORK // MIDDLE COLUMN -->
	<article class="<?php $CORE->CSS("columns-middle"); ?>" id="core_middle_column"><?php echo $CORE->ERRORCLASS(); ?><div id="core_ajax_callback"></div><?php echo $CORE->BANNER('middle_top'); ?>  
    
<?php } // end no custom home page ?>
           
<?php } ?>