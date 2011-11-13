<?php

class OEmbedYouku extends OEmbedService
{
	public static $host = 'v.youku.com';

	public $type = 'video';
	public $provider_name = '优酷';
	public $provider_url = 'http://www.youku.com/';
	public $width = 480;
	public $height = 400;
	public $thumbnail_width = 448;
	public $thumbnail_height = 336;
	
	public function parse($url)
	{
		preg_match("/\/v_show\/id_([\w]+).html/", $url, $match);
		$id = $match[1];
		$url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id;
		$info = json_decode(file_get_contents($url));
		$data = $info->data[0];
		$this->thumbnail_url = $data->logo;
		$this->title = $data->title;
		$this->html = '<embed src="http://player.youku.com/player.php/sid/'.$id.'/v.swf" allowFullScreen="true" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>';
		$this->author_name = $data->username;
		$this->author_url = 'http://u.youku.com/'.urlencode($data->username);
	}

	public function parse2($url)
	{
		Yii::import('application.vendors.phpQuery');
		$html = $this->_cget($url);
		phpQuery::newDocumentHTML($html);
		$this->title = pq('title')->text();
		$this->html = pq('#link3')->val();
		preg_match("/\/v_show\/id_([\w]+).html/", $url, $match);
		$id = $match[1];
		$this->thumbnail_url = $this->getYoukuThumbnail($id);
		// preg_match("/width=\"([\d]+)\" height=\"([\d]+)\"/", $embedHtml, $match);
		// $width = $match[1];
		// $height = $match[2];
		//echo pq('#vpvideoinfo')->attr('id');
		$authorLink = pq('#vpvideoinfo a.userName');
		$this->author_name = $authorLink->text();
		$this->author_url = $authorLink->attr('href');
	}
	
	public function getYoukuThumbnail($id)
	{
		$url = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$id;
		$info = json_decode(file_get_contents($url));
		return $info->data[0]->logo;
	}
}
