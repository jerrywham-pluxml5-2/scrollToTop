<?php
/**
 * Classe scrollToTop
 *
 * @version 2.1
 * @date	05/07/2014
 * @author	Cyril MAGUIRE
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
			$plxPlugin->setParam('speed', ($_POST['speed'] <= 0 ? 40 : $_POST['speed']), 'numeric');
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
#toplink {font-size: 0.9em;}
#toplink a, 
#toplink a:visited, 
#toplink a:link, 
#toplink a:hover, 
#toplink a:focus, 
#toplink a:active {
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
'#toplink a span {
	border:1px solid #A1A1A1;
	text-align:right;
	right:0;
	padding:5px;
	background:'.(!empty($_POST['colorTextToTop']) ? plxUtils::strCheck($_POST['colorTextToTop']) : '#B2B2B2').';
	color:'.(!empty($_POST['color']) ? plxUtils::strCheck($_POST['color']) : '#FFF').';
}' : '');
			plxUtils::write($css, PLX_PLUGINS.'scrollToTop/scrolltotop.css');

		if (!empty($_POST['textToTop'])) {
			$_POST['linkToTop'] = $_POST['textToTop'];
		}
		if ( !empty($_POST['linkToTop']) && ( (array_key_exists($_POST['linkToTop'], $aLinkToTop) && empty($_POST['textToTop']) ) || !empty($_POST['textToTop']) ) ) {
			$plxPlugin->setParam('linkToTop', $_POST['linkToTop'], 'cdata');
			$plxPlugin->saveParams();
            $licence = '/*
# ------------------ BEGIN LICENSE BLOCK ------------------
#
# Copyright (c) 2009 - 2014 Cyril MAGUIRE
# Licensed under the CeCILL v2.1 license.
# See http://www.cecill.info/licences.fr.html
#
# ------------------- END LICENSE BLOCK -------------------
*/';
			$js = '
;(function(window,undefined) {

    \'use_strict\';

    var timeOut;
    var isIE = isIE();
    var bodyTag = document.getElementsByTagName(\'body\');
    var idOfBody = bodyTag[0].getAttribute(\'id\');
    if (idOfBody == null) {
        idOfBody = \'top\';
        bodyTag[0].setAttribute(\'id\', \'top\');
    }
    
    function isIE() {
        var nav = navigator.userAgent.toLowerCase();
        return (nav.indexOf(\'msie\') != -1) ? parseInt(nav.split(\'msie\')[1]) : false;
    }

    function backToTop() {
        if (document.body.scrollTop!=0 || document.documentElement.scrollTop!=0){
            window.scrollBy(0,-50);
            timeOut=setTimeout(\'backToTop()\',40);
        }
        else {
            clearTimeout(timeOut);
        }
    }

    function getScrollPosition() {
        return Array((document.documentElement && document.documentElement.scrollLeft) || window.pageXOffset || self.pageXOffset || document.body.scrollLeft,(document.documentElement && document.documentElement.scrollTop) || window.pageYOffset || self.pageYOffset || document.body.scrollTop);
    }

    function Remove(idOfParent,idToRemove) {
        if (isIE) {
            document.getElementById(idToRemove).removeNode(true);
        } else {
            var Node1 = document.getElementById(idOfParent); 
            var len = Node1.childNodes.length;
            
            for(var i = 0; i < len; i++){           
                if (Node1.childNodes[i] != undefined && Node1.childNodes[i].id != undefined && Node1.childNodes[i].id == idToRemove){
                    Node1.removeChild(Node1.childNodes[i]);
                }
            }
        }   
    }

    function addElement(idOfParent,idToAdd,htmlToInsert) {
        var DomParent = document.getElementById(idOfParent);//id of body
        var newdiv = document.createElement(\'div\');

        newdiv.setAttribute(\'id\',idToAdd);
        newdiv.innerHTML = htmlToInsert;

        DomParent.appendChild(newdiv);
    }

    function displayBackButton() {
        var pos = [];
        var fleche = \''.(array_key_exists($plxPlugin->getParam('linkToTop'), $aLinkToTop) ? plxUtils::strCheck($_POST['linkToTop']) : '<span>'.plxUtils::strCheck($_POST['linkToTop']).'</span>').'\';

        if (isIE) {
            fleche = \'\u25B2\';
        }
        pos = getScrollPosition();
        var topLink = document.getElementById(\'toplink\');
        if (pos[1] > 150) {
            if (topLink == null) {
                addElement(idOfBody,\'toplink\',\'<a href="#" onclick="backToTop();return false;">\'+fleche+\'</a>\');
            }
        } else {
            if (topLink != null) {
                Remove(idOfBody,\'toplink\');
            }
        }
    }

    //add to global namespace
    window.onscroll = displayBackButton;
    window.displayBackButton = displayBackButton;
    window.backToTop = backToTop;


})(window);  
    ';

      $encoding = 10;
      $fast_decode = true;
      $special_char = false;
      $css = false;
      
      require 'class.JavaScriptPacker.php';
      $packer = new JavaScriptPacker($js, $encoding, $fast_decode, $special_char);
      $packed = $packer->pack();

			plxUtils::write($licence.$packed, PLX_PLUGINS.'scrollToTop/min.scrolltotop.js');
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
        <p><?php echo $plxPlugin->getLang('L_CONFIG_SPEED') ?></p>
		<?php plxUtils::printInput('speed', $plxPlugin->getParam('speed'), 'numeric'); ?>

	</fieldset>
	<br />
	<?php echo plxToken::getTokenPostMethod() ?>
	<input type="submit" name="submit" value="<?php echo $plxPlugin->getLang('L_CONFIG_SAVE') ?>" />
</form>
