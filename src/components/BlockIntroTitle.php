<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:24 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class BlockIntroTitle
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($introTitle, $introImage, $singleLine = false){
        $customLine = '';
        if($singleLine) $customLine = '<span style="line-height: 20px;height: 20px;"><br></span>';
        $img_file = PATH_IMAGES.$introImage;
        $this->pdf->Image($img_file, 0, 0, $this->pdf->getPageWidth(), 194, '', '', '', false, $this->pdf->image_quality, '', false, false, 0);

        $this->pdf->SetFont($this->pdf->font_medium);
        $html = '<h1 align="center" style="'.$this->pdf->h1_block_intro_title.'">'.$customLine.$this->pdf->getText($introTitle).'</h1>';
        $this->pdf->writeHTML($html, 0, false, true, false, 'C');

        $this->pdf->ln(120);
    }
}