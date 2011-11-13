<?php
class OEmbedWenku extends OEmbedService
{
	public static $host = 'wenku.baidu.com';

	public $type = 'rich';
	public $provider_name = '百度文库';
	public $provider_url = 'http://wenku.baidu.com/';
	public $width = 717;
	public $height = 419;
	// public $thumbnail_width = 480;
	// public $thumbnail_height = 360;
	
	public function parse($url)
	{
		Yii::import('application.vendors.phpQuery');
		preg_match("#view/(\w+).html#", $url, $match);
		$id = $match[1];
		//if(!$id)return false;
		$html = $this->_cget($url);
		phpQuery::newDocumentHTML($html);
		$this->description = pq('#summary')->text();
		$this->title = pq('title')->text();
		$this->thumbnail_url = 'http://wenku.baidu.com/img/'.$id;
		$this->html = '<embed height="500" align="middle" width="450" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="reader" src="http://wenku.baidu.com/static/flash/apireader.swf?docurl=http://wenku.baidu.com/play&amp;docid='.$id.'&amp;title=&amp;doctype=doc&amp;fpn=5&amp;npn=5&amp;readertype=external&catal=0&amp;cdnurl=http://txt.wenku.baidu.com/play" allowfullscreen="true" wmode="window" allowscriptaccess="always" bgcolor="#FFFFFF" ver="9.0.0"></embed>';		
		$this->author_url = pq('.Author')->text();
		$this->author_name = pq('.Author')->attr('href');
	}
}