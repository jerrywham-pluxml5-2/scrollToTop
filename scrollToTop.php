<?php
/**
 * Classe scrollToTop
 *
 * @version 2.0
 * @date	29/05/2014
 * @author	Cyril MAGUIRE
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
        $this->setParam('speed', '40', 'numeric');
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
		echo "\t".'<script type="text/javascript" src="'.PLX_PLUGINS.'scrollToTop/min.scrolltotop.js"></script>'."\n";
	}
}	