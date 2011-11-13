<?php
class ServiceProvider
{
	public static $services = array('Youku','Tudou','Ku6','56','Docin','Wenku');
	
	public static function serve($url,$options = array()){
		$format = isset($options['format']) ? $options['format'] : 'json';
		$urlInfo = parse_url($url); 
		if(!isset($urlInfo['host'])){
			echo 'error';return;
		}
		foreach (self::$services as $service) {
			$class = 'OEmbed'.$service;
			if($class::$host == $urlInfo['host']){
				$OEmbedService = new $class;
				break;
			}
		}
		if(!$OEmbedService)return;
		$OEmbedService->parse($url);
		$OEmbedService->render($format);
	}
}
