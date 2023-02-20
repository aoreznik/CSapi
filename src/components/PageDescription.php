<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:23 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class PageDescription
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($pageDescription, $isCustom = true, $font = false, $offset = 20){
        if(!$isCustom) $pageDescription = $this->pdf->getText($pageDescription);
        $font = $font ? $font : $this->pdf->font_light;
        $this->pdf->SetFont($font, '', 13);
        $this->pdf->Write(0,$pageDescription, '', 0, 'L', 1);
        $this->pdf->ln($offset);
    }
}