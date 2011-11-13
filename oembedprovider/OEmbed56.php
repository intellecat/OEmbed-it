<?php
class OEmbed56 extends OEmbedService
{
	public static $host = 'www.56.com';

	public $type = 'video';
	public $provider_name = '56网';
	public $provider_url = 'http://www.56.com/';
	public $width = 480;
	public $height = 405;
	public $thumbnail_width = 480;
	public $thumbnail_height = 360;
	
	public function parse($url)
	{
		preg_match("#/v_(\w+)\.html#", $url, $match);
		$code = $match[1];
		$apiUrl = "http://vxml.56.com/json/{$code}/";
		$json = file_get_contents($apiUrl);
		$data = json_decode($json);
		$info = $data->info;
		$this->html = '<embed src="http://player.56.com/v_'.$code.'.swf"  type="application/x-shockwave-flash" width="480" height="405" allowNetworking="all" allowScriptAccess="always"></embed>';
		$this->title = (string)$info->Subject;
		$this->thumbnail_url = (string)$info->bimg;
	}
}