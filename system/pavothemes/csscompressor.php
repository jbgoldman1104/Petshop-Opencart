<?php

/******************************************************
 * @package Pavo Opencart Theme Framework for Opencart 1.5.x
 * @version 3.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) May 2014 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class PavoCompressHelper {
	
	/**
	 *
	 */
	public static function process( $content , $url ){
		global $cssURL;   $cssURL = $url;
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $content);
        $content = preg_replace('/[ ]+([{};,:])/', '\1', $content);
        $content = preg_replace('/([{};,:])[ ]+/', '\1', $content);
        $content = preg_replace('/(\}([^\}]*\{\})+)/', '}', $content);
        $content = preg_replace('/<\?(.*?)\?>/mix', '', $content);
        $content = preg_replace_callback('/url\(([^\)]*)\)/', array('PavoCompressHelper', 'callbackReplaceURL'), $content);
		
        return $content;	
	}
	
	/**
	 *
	 */
	public static function replaceURL( $content, $url ){
		global $cssURL;   $cssURL = $url;
		$content = preg_replace_callback('/url\(([^\)]*)\)/', array('PavoCompressHelper', 'callbackReplaceURL'), $content);
        return $content;	
	}
	/**
	 *
	 */
	public static function callbackReplaceURL( $matches) {
        $url = str_replace(array('"', '\''), '', $matches[1]);
        global $cssURL;
        $url = self::converturl( $url, $cssURL );
        return "url('$url')";
    }
	
	/**
	 *
	 */
	public static function converturl($url, $cssurl) {
        $base = dirname($cssurl);
        if (preg_match('/^(\/|http)/', $url))
            return $url;
        /*absolute or root*/
        while (preg_match('/^\.\.\//', $url)) {
            $base = dirname($base);
            $url = substr($url, 3);
        }

        $url = $base . '/' . $url;
        return $url;
    }

	/**
	 * Load PHP Gzip Extension
	 *
	 * @param boolean $loadGzip
	 * @return boolean true if loaded.
	 */
	public static function loadGZip( $isGZ ) {		
		//$encoding = $this->clientEncoding();
		if (!$isGZ){
			$isGZ=false;
		}
		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			$isGZ=false;
		}
		return $isGZ; 
	}
	
}