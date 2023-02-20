<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class Description
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($description, $isCustom = true, $fontSize = 12, $offset = 20, $isHtml = false, $font = false){
        if(!$isCustom) $description = $this->pdf->getText($description);

        $font = $font ? $font : $this->pdf->font_regular;
        $this->pdf->SetFont($font, '', $fontSize);

        if($isHtml){
            $this->pdf->writeHTML($description);
        }else{
            $this->pdf->MultiCell(0, 0, $description, 0, 'L', 0, 1, '', '', true);
        }
        $this->pdf->ln($offset);
    }
}