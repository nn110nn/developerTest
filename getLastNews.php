<?

$url = 'https://lenta.ru/rss';
$xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

$items = $xml->channel->item;
$i = 0;

foreach($items as $k => $item) {
	
	echo trim($item->title) . "\r\n";
	echo trim($item->link) . "\r\n";
	echo trim($item->description) . "\r\n";
	
	if($i++ >= 4) {
		
		break;
	}
	
	echo "\r\n";
}

?>