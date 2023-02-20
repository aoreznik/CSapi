<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class PageTitle
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($pageTitle, $isCustom = true, $caps = false, $fill = true, $offsetAfter = 10, $offsetBefore = 5, $icon = null){
        if(!$isCustom) $pageTitle = $this->pdf->getText($pageTitle);

        if($caps) $pageTitle = mb_convert_case($pageTitle, MB_CASE_UPPER, "UTF-8");

        $color = $this->pdf->template['font-color'];
        $fillColor = $this->pdf->template['title-bg'];

        $this->pdf->ln($offsetBefore);

        if($icon){
            $this->pdf->icon->set($icon);
        }

        $this->pdf->SetTextColor($color[0], $color[1], $color[2]);
        $this->pdf->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);
        $this->pdf->SetFont($this->pdf->font_medium, '', 14);
        $this->pdf->MultiCell(0, 20, $pageTitle, 0, 'L', $fill, 1, '', '', true, 0, true);
        $this->pdf->SetTextColor(0,0,0);

        $this->pdf->ln($offsetAfter);



    }
}