<?php
Class Application_View_helper_BaseUrl {
	function baseUrl(){
		$fc = Zend_Controller_Font::getInstance();
		return $fc->getBaseUrl();
	}
}