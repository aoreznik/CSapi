<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class Filled
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($bgColor){
        $this->pdf->AddPage();
        $fillColor = $this->pdf->utils->hex2rgb($bgColor);
        $this->pdf->SetFillColor($fillColor[0],$fillColor[1],$fillColor[2]);
        $this->pdf->Rect(0, 0, $this->pdf->getPageWidth(), $this->pdf->getPageHeight(),'F');
    }
}