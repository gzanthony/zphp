<?php
/**
 * User: shenzhe
 * Date: 13-6-17
 * Json view
 */


namespace ZPHP\View\Adapter;
use ZPHP\View\Base,
    ZPHP\Core\Config;

class Xml extends Base
{
    public function xmlEncode()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= "\n<root>\n";
        $xml .= $this->dataToXml($this->model);
        $xml .= "</root>\n";
        return $xml;
    }

    private function dataToXml($data)
    {
        $xml = "";
        foreach ($data as $key => $val) {
            \is_numeric(\substr($key, 0, 1)) && $key = "item id=\"$key\"";
            $xml .= "<{$key}>";
            $xml .= (\is_array($val) || \is_object($val)) ? $this->dataToXml($val) : $val;
            list($key) = \explode(' ', $key);
            $xml .= "</{$key}>\n";
        }

        return $xml;
    }

    public function display()
    {
        if (Config::get('server_mode') == 'Http') {
            \header("Content-Type:text/xml; charset=utf-8");
        }
        echo $this->xmlEncode();
    }
}