<?php
/**
 * Classe scrollToTop
 *
 * @version 1.2
 * @date	20/01/2013
 * @author	Patrice Blondel, Cyril MAGUIRE
 **/
class scrollToTop extends plxPlugin {
	
	
	/**
	 * Constructeur de la classe
	 *
	 * @return	null
	 * @author	Cyril MAGUIRE 
	 **/	
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		$this->setConfigProfil(PROFIL_ADMIN);
		# Ajouts des hooks
		$this->addHook('ThemeEndHead', 'ThemeEndHead');
		$this->addHook('ThemeEndBody', 'ThemeEndBody');
	}

	public function onActivate() {
				$css = '/** Bouton haut de page **/
#toplink {font-size: 0.9em;}
#toplink a, 
#toplink a:visited, 
#toplink a:link, 
#toplink a:hover, 
#toplink a:focus, 
#toplink a:active {
    display:block;
    color: #A1A1A1;
    position: fixed;
    right: 10px;
    bottom: 16px;
    width: 25px;
    height:30px;
    font-family: Times, Serif; /* Pour une compatibilité maximale de l\'affichage de la flèche, ne pas modifier la police */
    font-size:230%;
    line-height:0;
    opacity:0.6;
    text-decoration: none;
    outline:0;
}';
$js = '/*
# ------------------ BEGIN LICENSE BLOCK ------------------
#
# This file is part of SIGesTH
#
# Copyright (c) 2009 - 2014 Cyril MAGUIRE, (!Pragmagiciels)
# Licensed under the CeCILL v2.1 license.
# See http://www.cecill.info/licences.fr.html
#
# ------------------- END LICENSE BLOCK -------------------
*/
;(function(window,undefined) {

    \'use_strict\';

    var timeOut;
    var isIE = isIE();

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
        var fleche = \'\u21E7\';

        if (isIE) {
            fleche = \'\u25B2\';
        }
        pos = getScrollPosition();
        var topLink = document.getElementById(\'toplink\');
        if (pos[1] > 150) {
            if (topLink == null) {
                addElement(\'top\',\'toplink\',\'<a href="#" onclick="backToTop();return false;">\'+fleche+\'</a>\');
            }
        } else {
            if (topLink != null) {
                Remove(\'top\',\'toplink\');
            }
        }
    }

    //add to global namespace
    window.onscroll = displayBackButton;
    window.displayBackButton = displayBackButton;
    window.backToTop = backToTop;


})(window);  
    ';
		file_put_contents(PLX_PLUGINS.'scrollToTop/scrolltotop.js', $js);
		file_put_contents(PLX_PLUGINS.'scrollToTop/scrolltotop.css', $css);
			
		$this->setParam('color', '#A1A1A1', 'cdata');
		$this->setParam('linkToTop', '\u21E7', 'cdata');
		$this->saveParams();
	}
	
	/**
	 * Méthode pour afficher la mise en page 
	 *
	 * @author Cyril MAGUIRE
	 */
	public function ThemeEndHead()
	{
		echo "\t".'<link rel="stylesheet" type="text/css" href="'.PLX_PLUGINS.'scrollToTop/scrolltotop.css" media="screen" />'."\n";
	}
	
	/**
	 * Méthode pour afficher le javascript
	 *
	 * @author Cyril MAGUIRE
	 */
	public function ThemeEndBody()
	{
		echo "\t".'<script type="text/javascript" src="'.PLX_PLUGINS.'scrollToTop/scrolltotop.js"></script>'."\n";
	}
}	