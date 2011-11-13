<?php
class OEmbedService
{
	public static $host;
	private static $instance;

	public $version = '1.0';
	public $type = 'video';
	public $provider_name;
	public $provider_url;
	public $title;
	public $description;
	public $html;
	public $width;
	public $height;
	public $thumbnail_url;
	public $thumbnail_width;
	public $thumbnail_height;
	public $author_name;
	public $author_url;
	
	function __construct(){}
	
	public function render($format='json')
	{
		foreach ($this as $key => $value) {
			if($value){
				$data[$key] = $value;
			}
		}
		if($format=='json'){
			header('Content-type: application/json');
			echo json_encode($data);
		}elseif($format=='xml'){
			header ("content-type: text/xml");
			$xml = new SimpleXMLElement('<xml/>');
			foreach ($data as $key => $value) {
				$xml->addChild($key,$value);
			}
			echo $xml->asXML();
		}
	}
	
	protected function _cget($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 (.NET CLR 3.5.30729)');
		$html = curl_exec($ch);
		curl_close($ch);
		return $html;
	}
}
