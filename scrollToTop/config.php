<?php
/**
 * Classe scrollToTop
 *
 * @version 1.2
 * @date	20/01/2013
 * @author	Patrice Blondel, Cyril MAGUIRE
 **/
 
	if(!defined('PLX_ROOT')) exit; 
	?>
<style type="text/css">
	#radio label {
		font-size:230%;
		margin-left: 20px;
	}
</style>
	<?php
	# Control du token du formulaire
	plxToken::validateFormToken($_POST);

	$aLinkToTop = array(
		'\u21E7'=>'&#8679;',
		'\u21E1'=>'&#8673;',
		'\u219F'=>'&#8607;',
		'\u2191'=>'&uarr;',
		'\u21DE'=>'&#8670;',
		'\u27F0'=>'&#10224;',
		'\u25B2'=>'&#9650;',
		'\u261D'=>'&#9757;'
	);
	
	if(!empty($_POST)) {
		if (!empty($_POST['color']) ) {
			$plxPlugin->setParam('color', $_POST['color'], 'cdata');
			if (!empty($_POST['textToTop']) && !empty($_POST['colorTextToTop'])) {
				$plxPlugin->setParam('colorTextToTop', $_POST['colorTextToTop'], 'cdata');
			}
			if (!empty($_POST['textToTop']) && empty($_POST['colorTextToTop'])) {
				$plxPlugin->setParam('colorTextToTop', '#B2B2B2', 'cdata');
			}
			if (empty($_POST['textToTop'])) {
				$plxPlugin->setParam('colorTextToTop', '', 'cdata');
			}
		} else {
			$plxPlugin->setParam('color', '#A1A1A1', 'cdata');
		}
			$plxPlugin->saveParams();
			
			$css = '/** Bouton haut de page **/
#scrollToTop {font-size: 0.9em;}
#scrollToTop a, 
#scrollToTop a:visited, 
#scrollToTop a:link, 
#scrollToTop a:hover, 
#scrollToTop a:focus, 
#scrollToTop a:active {
    display:block;
    color: '.plxUtils::strCheck($_POST['color']).';
    position: fixed;
    right: 10px;
    bottom: 16px;
    height:30px;
    font-family: Times, Serif; /* Pour une compatibilité maximale de l\'affichage de la flèche, ne pas modifier la police */
    font-size:230%;
    line-height:0;
    opacity:0.6;
    text-decoration: none;
    outline:0;
}'.(!empty($_POST['textToTop']) ? 
'#scrollToTop a span {
	border:1px solid #A1A1A1;
	text-align:right;
	right:0;
	padding:5px;
	background:'.(!empty($_POST['colorTextToTop']) ? plxUtils::strCheck($_POST['colorTextToTop']) : '#B2B2B2').';
	color:'.(!empty($_POST['color']) ? plxUtils::strCheck($_POST['color']) : '#FFF').';
}' : '');
			file_put_contents(PLX_PLUGINS.'scrollToTop/scrolltotop.css', $css);

		if (!empty($_POST['textToTop'])) {
			$_POST['linkToTop'] = $_POST['textToTop'];
		}
		if ( !empty($_POST['linkToTop']) && ( (array_key_exists($_POST['linkToTop'], $aLinkToTop) && empty($_POST['textToTop']) ) || !empty($_POST['textToTop']) ) ) {
			$plxPlugin->setParam('linkToTop', $_POST['linkToTop'], 'cdata');
			$plxPlugin->saveParams();
			$js = 'jQuery(function($){
	$(window).scroll(function() {
	if($(window).scrollTop() == 0){
		$(\'#scrollToTop\').fadeOut("fast");
	} else {
		if($(\'#scrollToTop\').length == 0){
			$(\'body\').append(\'<div id="scrollToTop">\'+
			\'<a href="#">'.(array_key_exists($plxPlugin->getParam('linkToTop'), $aLinkToTop) ? plxUtils::strCheck($_POST['linkToTop']) : '<span>'.plxUtils::strCheck($_POST['linkToTop']).'</span>').'</a>\'+
			\'</div>\');
		}
		$(\'#scrollToTop\').fadeIn("fast");
	}
});
$(\'#scrollToTop a\').live(\'click\', function(event){
		event.preventDefault();
		$(\'html,body\').animate({scrollTop: 0}, \'slow\');
	})
});';
			file_put_contents(PLX_PLUGINS.'scrollToTop/scrolltotop.js', $js);
		}
		header('Location: parametres_plugin.php?p=scrollToTop');
		exit;
	}
?>

<h2><?php $plxPlugin->lang('L_TITLE') ?></h2>

<form action="parametres_plugin.php?p=scrollToTop" method="post">
	<fieldset class="withlabel">
		<p><?php echo $plxPlugin->getLang('L_CONFIG_COLOR') ?> #A1A1A1</p>
		<?php plxUtils::printInput('color', $plxPlugin->getParam('color'), 'text'); ?>

		<p><?php echo $plxPlugin->getLang('L_CONFIG_ARROW') ?></p>
		<div id="radio">
		<?php $i=0;foreach ($aLinkToTop as $k => $v) {
			$i++;
			echo '<input id="id_'.$i.'linkToTop" name="linkToTop" type="radio" value="'.$k.'" '.($k == $plxPlugin->getParam('linkToTop') ? 'checked="checked"' : '').'/><label for="id_'.$i.'linkToTop">'.$v.'</label><br/>'."\n";
		} ?>

		</div>
		<p><?php echo $plxPlugin->getLang('L_CONFIG_FREE_TXT') ?></p>
		<?php plxUtils::printInput('textToTop', (array_key_exists($plxPlugin->getParam('linkToTop'), $aLinkToTop) ? '' : $plxPlugin->getParam('linkToTop') ), 'text'); ?><a class="help" title="<?php echo $plxPlugin->getLang('L_HELP_FREE_TXT'); ?>">&nbsp;</a>
		<p><?php echo $plxPlugin->getLang('L_CONFIG_COLOR_FREE_TXT') ?> #B2B2B2</p>
		<?php plxUtils::printInput('colorTextToTop', (array_key_exists($plxPlugin->getParam('linkToTop'), $aLinkToTop) ? '' : $plxPlugin->getParam('colorTextToTop') ), 'text'); ?>

	</fieldset>
	<br />
	<?php echo plxToken::getTokenPostMethod() ?>
	<input type="submit" name="submit" value="<?php echo $plxPlugin->getLang('L_CONFIG_SAVE') ?>" />
</form>
