<?php
namespace App\Scraper;

require dirname(__FILE__).'/simple_html_dom.php';

class Scraper
{
    static function crawler(string $url, string $tag)
    {
        $html = file_get_html($url);

        $ret = $html->find($tag, 0)->plaintext;
        echo $ret;
    }
}