<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:24 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class TopicsList
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($topics, $highlight = true, $headers = ['Symptom', 'Result'], $subtitle = false){
        $this->pdf->AddPage();
        $this->showGroupList($topics, $highlight, $headers, $subtitle);
    }

    public function showGroupList($topics, $highlight, $headers, $subtitle){
        $this->pdf->pageTitle->set($topics[0]['type'], false);
        if($subtitle) $this->pdf->pageDescription->set($subtitle, false);

        $headerList = [
            $this->pdf->getText($headers[0]),
            $this->pdf->getText($headers[1]),
        ];
        $fieldsList = ['name', 'descr'];
        $sizeList = ['30%', '69%'];
        $alignList = ['left', 'left'];
        $colorList = [null, 'color'];

        $this->pdf->table->set($headerList, $topics, $fieldsList, $sizeList, $colorList, $alignList, null, $highlight, 15);
    }
}