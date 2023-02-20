<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/9/17
 * Time: 11:33 AM
 */

namespace Solo;

class Utils{

    public function getGradientColor($color1, $color2, $percent)
    {
        return $this->makeGradientColor($this->hexToRgb($color1), $this->hexToRgb($color2), $percent);
    }

    public function hexToRgb($hex)
    {
        $color['r'] = hexdec(substr($hex, 0, 2));
        $color['g'] = hexdec(substr($hex, 2, 2));
        $color['b'] = hexdec(substr($hex, 4, 2));
        return $color;
    }

    public function makeGradientColor($color1, $color2, $percent)
    {
        $r = $this->makeChannel($color1['r'], $color2['r'], $percent);
        $g = $this->makeChannel($color1['g'], $color2['g'], $percent);
        $b = $this->makeChannel($color1['b'], $color2['b'], $percent);
        return $this->makeColorPiece($r) . $this->makeColorPiece($g) . $this->makeColorPiece($b);
    }

    public function makeChannel($a, $b, $per)
    {
        return ($a + round(($b - $a) * ($per)));
    }

    public function makeColorPiece($num)
    {
        $num = min($num, 255);
        $num = max($num, 0);
        $str = dechex($num);//PARSE TO HEX FROM DEC
        if (strlen($str) < 2) {
            return $str = "0" . $str;
        } else {
            return $str;
        }
    }

    public function hex2rgb($hexColor){
        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
        return [$r, $g, $b];
    }

    public function getParagraphs($text){
        $paragraphLength = 3;
        $sentences = preg_split('/(?<=[.?!])\s+(?=[a-zа-я])/i', $text);
        $listsOfParagraphs = array_chunk($sentences, $paragraphLength);
        $paragraphs = [];

        $lastList = $listsOfParagraphs[count($listsOfParagraphs)-1];
        if(count($lastList) < 2){
            $listsOfParagraphs[count($listsOfParagraphs)-2][] = $lastList[0];
            unset($listsOfParagraphs[count($listsOfParagraphs)-1]);
        }
        foreach ($listsOfParagraphs as $list){
            $paragraphs[] = join(" ",$list);
        }
        return $paragraphs;
    }

    public function toPrecision($number, $precision) {
        if ($number == 0) return 0;
        $exponent = floor(log10(abs($number)) + 1);
        $significand =
            round(
                ($number / pow(10, $exponent))
                * pow(10, $precision)
            )
            / pow(10, $precision);
        return $significand * pow(10, $exponent);
    }

    public function fixedPercent ($value, $toNumber = false, $precision = 2)
    {
        $per = $value;
        if($per > 0) {
            if ($per < 1) {
                $per = $this->toPrecision($per, $precision);
                if (!$toNumber) {
                    if ($per < 0.01) {
                        $per = '< 0.01%';
                    } else {
                        $per = $per . '%';
                    }
                }
            } else {
                $per = round($per, $precision);
//                $per = floor($per * 100) / 100;
                if (!$toNumber) {
                    $per = $per . '%';
                }
            }
        }else {
            if ($per > -1) {
                $per = $this->toPrecision($per, $precision);
                if (!$toNumber) {
                    if ($per > -0.01) {
                        $per = '> -0.01%';
                    } else {
                        $per = $per . '%';
                    }
                }
            } else {
                if ($per) {
                    $per = round($per, $precision);
                    if (!$toNumber) {
                        $per = $per . '%';
                    }
                } else {
                    $per = null;
                }
            }
        }

        if(!$toNumber) {
            return $per;
        }else {
            return (float)$per;
        }
    }
}