<?php

class OEmbedTudou extends OEmbedService
{
	public static $host = 'www.tudou.com';

	public $type = 'video';
	public $provider_name = '土豆';
	public $provider_url = 'http://www.tudou.com/';
	public $width = 480;
	public $height = 400;
	public $thumbnail_width = 320;
	public $thumbnail_height = 240;
	
	public function parse($url)
	{
		preg_match("#view/([-\w]+)/#", $url, $matches);
		if(!empty($matches) && $matches[1]){
			$code = $matches[1];
			$html = $this->_cget($url);
			//iid = (\d+)|icode = '(\w+)'|
			preg_match_all("/oid = (\d+)|onic = \"(.*)\"|title = \"(.*)\"|desc = \"(.*)\"|bigItemUrl = \"(.*)\"/", $html, $matches);
			$oid = $matches[1][0];
			$this->author_name = iconv("GB2312", "UTF-8", $matches[2][1]);
			$this->title = iconv("GB2312", "UTF-8", $matches[3][2]);
			$this->description = iconv("GB2312", "UTF-8", $matches[4][3]);
			$this->thumbnail_url = $matches[5][4];
			$this->html = "<embed src=\"http://www.tudou.com/v/{$code}/v.swf\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" wmode=\"opaque\" width=\"480\" height=\"400\"></embed>";
			$author_url = 'http://www.tudou.com/home/_'.$oid;
		}
	}
}