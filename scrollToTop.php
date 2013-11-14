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
#scrollToTop {font-size: 0.9em;}
#scrollToTop a, 
#scrollToTop a:visited, 
#scrollToTop a:link, 
#scrollToTop a:hover, 
#scrollToTop a:focus, 
#scrollToTop a:active {
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
$js = 'jQuery(function($){
	$(window).scroll(function() {
	if($(window).scrollTop() == 0){
		$(\'#scrollToTop\').fadeOut("fast");
	} else {
		if($(\'#scrollToTop\').length == 0){
			$(\'body\').append(\'<div id="scrollToTop">\'+
			\'<a href="#">\u21E7</a>\'+
			\'</div>\');
		}
		$(\'#scrollToTop\').fadeIn("fast");
	}
});
$(\'#scrollToTop a\').on(\'click\', function(event){
		event.preventDefault();
		$(\'html,body\').animate({scrollTop: 0}, \'slow\');
	})
});';
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
		echo "\t".'<script type="text/javascript">
				/* <![CDATA[ */
				!window.jQuery && document.write(\'<script  type="text/javascript" src="'.PLX_PLUGINS.'scrollToTop/jQuery-v1.10.2.js"><\/script>\');
				/* !]]> */
			</script>'."\n";
		echo "\t".'<script type="text/javascript" src="'.PLX_PLUGINS.'scrollToTop/scrolltotop.js"></script>'."\n";
	}
}	