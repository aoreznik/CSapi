<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:24 PM
 */


namespace Solo\components;

use Solo\SoloReport;

class CoverTitle
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($coverTitle){
        $this->pdf->SetFont($this->pdf->font_medium);
        $html = '<h6 style="'.$this->pdf->h6_cover_title.'">'.$this->pdf->getText($coverTitle).'</h6>';
        //$this->pdf->writeHTML($html, 0, false, true, false, '');
        //$this->pdf->writeHTMLCell($this->pdf->getWidthPercent($this->pdf->template['cover-text-max-width']), 0, '', '', $html);

        $this->pdf->SetTextColor(254,254,254);
        $this->pdf->SetFont($this->pdf->font_medium, '', 40);
        $this->pdf->MultiCell($this->pdf->getWidthPercent($this->pdf->template['cover-text-max-width']), 0, $html, 0, 'L', 0, 1, '', '', true, 0, true);
        $this->pdf->SetTextColor(0,0,0);

        $this->pdf->ln(30);
    }
}