<?php
class OEmbedKu6 extends OEmbedService
{
	public static $host = 'v.ku6.com';

	public $type = 'video';
	public $provider_name = '酷6';
	public $provider_url = 'http://www.ku6.com/';
	public $width = 480;
	public $height = 400;
	public $thumbnail_width = 480;
	public $thumbnail_height = 360;
	
	public function parse($url)
	{
		$apiUrl = "http://v.ku6.com/repaste.htm?url=";
		$xml = file_get_contents($apiUrl.urlencode($url));
		$xmlEl = new SimpleXMLElement($xml);
		$result = $xmlEl->result;
		$this->html = '<script data-vid="'.(string)$result->vid.'" src="http://player.ku6.com/out/v.js" data-width="480" data-height="400"></script>';
		$this->title = (string)$result->title;
		$this->description = (string)$result->desc;
		$this->thumbnail_url = (string)$result->coverurl;
	}
}