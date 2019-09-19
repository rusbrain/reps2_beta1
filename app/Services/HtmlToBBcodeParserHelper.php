<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.17.19
 * Time: 12:50
 */

namespace App\Services;

class HtmlToBBcodeParserHelper
{

    public function __construct()
    {

    }

    public function html_bbcode_format($replace)
    {
        $replace = str_replace("&", "&amp;", $replace);
        $replace = preg_replace("/<!--.*?-->/mss", "", $replace);
        $replace = preg_replace('#<meta(.*?)>#is', '', $replace);
        $replace = preg_replace('#<hr(.*?)>#is', '', $replace);
        $replace = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $replace);
        $replace = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $replace);
        $replace = preg_replace('#<detalis(.*?)>(.*?)</detalis>#is', '', $replace);

        $replace = preg_replace('#<details(.*?)>(.*?)</details>#is', "[spoiler]$2[/spoiler]", $replace);
        $replace = preg_replace('/\<summary(.*?)\>/i', '', $replace);
        $replace = preg_replace('/\<\/summary(.*?)\>/i', '', $replace);

        $replace = str_replace("\r\n", "", $replace);
        $replace = str_replace("\n", "", $replace);
        $replace = preg_replace('/\<p(.*?)\>/i', '', $replace);
        $replace = preg_replace('/\<\/p\>/i', "\r\n", $replace);

        //quote without name
        $replace = preg_replace('#<code(.*?)>(.*?)</code>#is', '[code]$2[/code]', $replace);
        $replace = preg_replace('#<blockquote(.*?)>(.*?)</blockquote>#is', '[quote]$2[/quote]', $replace);

        $replace = str_replace("\r\t", "", $replace);
        $replace = str_replace("\t", "", $replace);

        $replace = preg_replace('/\<br\>/i', "\r\n", $replace);
        $replace = preg_replace('/\<br \/\>/i', "\r\n", $replace);

        $replace = preg_replace_callback('/\<img(.*?)src="(.*?)"(.*?) \/>/i', function ($matches) {
            return "[img]" . $matches[2] . "[/img]";
        }, $replace);

        $replace = preg_replace_callback('/\<img(.*?)src="(.*?)"(.*?)>/i', function ($matches) {
            return "[img]" .$matches[2] . "[/img]";
        }, $replace);

        $replace = preg_replace('/\<font size=\"([1-7])\"\>((\s|.)+?)\<\/font>/i', '[size=\\1]\\2[/size]', $replace);
        $replace = preg_replace('/\<font color=\"(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\"\>((\s|.)+?)\<\/font>/i', '[color=\\1]\\2[/color]', $replace);
        $replace = preg_replace('/\<font color=\"([a-zA-Z]+)\]((\s|.)+?)\<\/font>/i', '[color=\\1]\\2[/color]', $replace);

        $replace = preg_replace_callback('/\<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/i', function ($matches) {
            return "[url=" . $matches[2] . "]" . $matches[4] . "[/url]";
        }, $replace);

        $replace = preg_replace('/<ol(.*?)>(.*?)<\/ol>/s', '[list]$2[/list]', $replace);
        $replace = preg_replace('/<ul(.*?)>(.*?)<\/ul>/s', '[list]$2[/list]', $replace);
        $replace = preg_replace('/<li(.*?)>(.*?)<\/li>/s', '[*]$2', $replace);

        $replace = preg_replace('/<table(.*?)>(.*?)<\/table>/s', '[table]$2[/table]', $replace);
        $replace = preg_replace('/<tr(.*?)>(.*?)<\/tr>/s', '[tr]$2[/tr]', $replace);
        $replace = preg_replace('/<td(.*?)>(.*?)<\/td>/s', '[td]$2[/td]', $replace);
        $replace = preg_replace('/<th(.*?)>(.*?)<\/th>/s', '[td]$2[/td]', $replace);


        $replace = preg_replace('/\<strong\>((\s|.)+?)\<\/strong>/i', '[b]\\1[/b]', $replace);
        $replace = preg_replace('/\<b\>((\s|.)+?)\<\/b>/i', '[b]\\1[/b]', $replace);
        $replace = preg_replace('/\<i\>((\s|.)+?)\<\/i>/i', '[i]\\1[/i]', $replace);
        $replace = preg_replace('/\<em\>((\s|.)+?)\<\/em>/i', '[i]\\1[/i]', $replace);
        $replace = preg_replace('/\<u\>((\s|.)+?)\<\/u>/i', '[u]\\1[/u]', $replace);
        $replace = preg_replace('/\<s\>((\s|.)+?)\<\/s>/i', '[s]\\1[/s]', $replace);
        $replace = preg_replace('/\<del\>((\s|.)+?)\<\/del>/i', '[s]\\1[/s]', $replace);

        $replace = str_replace('&nbsp;', ' ', $replace);

        $replace = $this->font_related_parser($replace);

        $replace = preg_replace_callback('/<h([1-6]) align=(.*?)>(.*?)<\/h([1-6])>/', function ($matches) {
            $align = $matches[2];
            $tag = $matches[1];
            $content = $matches[3];
            return '[' . $align . ']<h' . $tag . '>' . $content . '</h' . $tag . '>[' . $align . ']';
        }, $replace);

        $replace = preg_replace_callback('/<h([1-6])>(.*?)<\/h([1-6])>/', function ($matches) {
            return $this->heading_parser($matches);
        }, $replace);

        $replace = str_replace('<?xml encoding="UTF-8">', '', $replace);
        $replace = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace(array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $replace));
        $replace = str_replace('"', '"', $replace);
        $replace = preg_replace('/\<span(.*?)\>/i', '', $replace);
        $replace = preg_replace('/\<\/span\>/i', '', $replace);

        $replace = preg_replace('/\<div(.*?)\>/i', '', $replace);
        $replace = preg_replace('/\<\/div\>/i', '', $replace);
        return $replace;
    }

    public function font_related_parser($text)
    {
        $allowed_styles = array('size' => 'font-size', 'color' => 'color', 'font' => 'font-family', 'text-align' => 'text-align');
        $html_string = '<body>' . $text . '</body>';

//        $dom = new \domDocument();
//        $dom->loadHtml($html_string);

        $dom = new \domDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->loadHtml('<?xml encoding="UTF-8">' . $html_string);
        $dom->encoding = 'UTF-8';
//          dd($dom->saveHTML());
        $elements = $dom->getElementsByTagName('body');
        foreach ($elements as $element) {
            $this->clearHtml($element, $allowed_styles);
        }

        $text = $dom->saveHTML();
        return $text;
    }

    public function clearHtml($tree, $allowed_styles)
    {
        try{
            if ($tree->nodeType != XML_TEXT_NODE) {
                if ($tree->hasAttribute('style')) {

                    $style = strtolower(trim($tree->getAttribute('style')));
                    preg_match_all('/([a-z\-]+):(.*?);/', $style, $matches);

                    for ($i = 0; $i < sizeof($matches[0]); $i++) {
                        $style_property = trim($matches[1][$i]);
                        $style_value = trim($matches[2][$i]);
                        if (in_array($style_property, $allowed_styles)) {
                            $styleKey = array_search($style_property, $allowed_styles);

                            if ($styleKey == 'text-align') {
                                if ($style_value == 'left') {
                                    $tree->nodeValue = '[left]' . $tree->nodeValue . '[/left]';
                                } elseif ($style_value == 'center') {
                                    $tree->nodeValue = '[center]' . $tree->nodeValue . '[/center]';
                                } elseif ($style_value == 'right') {
                                    $tree->nodeValue = '[right]' . $tree->nodeValue . '[/right]';
                                }
                            } elseif ($styleKey == 'size') {
                                $size = $this->convertSize($style_value);
                                $tree->nodeValue = '[' . $styleKey . '=' . $size . ']' . $tree->nodeValue . '[/' . $styleKey . ']';

                            } else {
                                $tree->nodeValue = '[' . $styleKey . '=' . $style_value . ']' . $tree->nodeValue . '[/' . $styleKey . ']';
                            }
                            continue;
                        }
                    }
                    $tree->removeAttribute('style');
                }
                if ($tree->childNodes) {
                    foreach ($tree->childNodes as $child) {
                        $this->clearHtml($child, $allowed_styles);
                    }
                }
            }
        } catch (\Exception $e) {

        }

    }

    public function heading_parser($matches)
    {
        $heading_size = $matches[1];
        $text = $matches[2];
        switch ($heading_size) {
            case 1:
                $size = 6;
                break;
            case 2:
                $size = 5;
                break;
            case 3:
                $size = 4;
                break;
            case 4:
                $size = 3;
                break;
            case 5:
                $size = 2;
                break;
            case 6:
                $size = 1;
                break;
            default:
                break;
        }
        return '[size=' . $size . ']' . $text . '[/size]';
    }

    public function convertSize($size)
    {
        $pixsize = (int)($size);
        $fontsize = 0;
        if ($pixsize <= 10) {
            $fontsize = 1;
        } else if ($pixsize > 10 && $pixsize <= 13) {
            $fontsize = 2;
        } else if ($pixsize > 13 && $pixsize <= 16) {
            $fontsize = 3;
        } else if ($pixsize > 16 && $pixsize <= 18) {
            $fontsize = 4;
        } else if ($pixsize > 18 && $pixsize <= 24) {
            $fontsize = 5;
        } else if ($pixsize > 24 && $pixsize <= 32) {
            $fontsize = 6;
        } else if ($pixsize > 32) {
            $fontsize = 7;
        }
        return $fontsize;
    }
}
