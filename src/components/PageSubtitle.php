<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class PageSubtitle
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($pageSubtitle, $isCustom = true, $color = '#000000'){
        if(!$isCustom) $pageSubtitle = $this->pdf->getText($pageSubtitle);
        $textColor = $this->pdf->utils->hex2rgb($color);
        $this->pdf->SetTextColor($textColor[0], $textColor[1], $textColor[2]);
        $this->pdf->SetFont($this->pdf->font_regular, '', 22);
        $this->pdf->MultiCell(0,0, $pageSubtitle, 0, 'L', 0, 1);
        $this->pdf->ln(20);

        //reset font style
        $this->pdf->SetTextColor(0,0,0);
        $this->pdf->SetFont($this->pdf->font_light, '', 13);
    }
}