<?php
class OEmbedDocin extends OEmbedService
{
	public static $host = 'www.docin.com';

	public $type = 'video';
	public $provider_name = '豆丁网';
	public $provider_url = 'http://www.docin.com/';
	public $width = 650;
	public $height = 490;
	public $thumbnail_width = 480;
	public $thumbnail_height = 360;
	
	public function parse($url)
	{
		Yii::import('application.vendors.phpQuery');
		preg_match("#/p-(\d+).html#", $url, $match);
		$id = $match[1];
		//if(!$id)return false;
		$html = $this->_cget($url);
		phpQuery::newDocumentHTML($html);
		//$userLink = pq('.userinfo a');
		//var_dump(pq('ul.userinfo')->html());
		//$this->$author_name = pq('.userinfo-tips a')->attr('title');
		//$this->$author_url = pq('.userinfo-tips a')->attr('href');
		$this->description = pq('meta[name="description"]')->attr('content');
		$this->title = pq('meta[property="og:title"]')->attr('content');
		$this->thumbnail_url = pq('meta[property="og:image"]')->attr('content');
		$this->html = "<embed src='http://www.docin.com/DocinViewer-{$id}-144.swf' width='650' height='490' type=application/x-shockwave-flash ALLOWFULLSCREEN='true' ALLOWSCRIPTACCESS='always'></embed>";
	}
}