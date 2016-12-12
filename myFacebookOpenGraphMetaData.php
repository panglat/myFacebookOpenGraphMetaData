<?php
/**
 * plugin blankContentPlugin
 * @version 1.2
 * @package blankContentPlugin
 * @copyright Copyright (c) Jahr Firmennamen URL
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

/**
 * Platz für Informationen
 * =======================
 *
 * Anwendung im Content:
 *   {MyFacebookOpenGraphMetaData}
 *
 * Anwendung im Content mit Parameterübergabe:
 *   {MyFacebookOpenGraphMetaData param1=Hello!|param2=it works fine|param3=Joomla! rocks ;-)}
 */


defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');


class plgContentMyFacebookOpenGraphMetaData extends JPlugin {
	function plgContentMyFacebookOpenGraphMetaData( &$subject ) {
		parent::__construct( $subject );
	}

	public function getParam($param, $text, $default=null) {
		if(preg_match_all("/".$param."='(.*?)'/", trim($text), $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				return $match[1];
			}
		}
		return $default;
	}
	
	public function onContentPrepare($context, &$article, &$params, $limitstart) {
		$regex = '/{MyFacebookOpenGraphMetaData\s*(.*?)}/i';
		$article->text = preg_replace_callback($regex,array($this,"form"), $article->text);
		return true;
	}
	
	public function form($matches) {
		$property = $this->getParam("property",$matches[1]);
		$content = $this->getParam("content",$matches[1]);
		if($property != null && $content != null) {
			$document = JFactory::getDocument();
			$document->addCustomTag("<meta property=\"".$property."\" content=\"".$content."\" />");
		}
		return "";
	}
}

?>