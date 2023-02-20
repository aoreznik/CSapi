<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class Icon
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($filename, $offsetY = 4){
        $path = PATH_IMAGES.'icons/'.$filename.'.jpg';
        $posX = $this->pdf->GetX() - 15;
        $posY = $this->pdf->GetY() + $offsetY;
        $this->pdf->image($path,$posX,$posY,10,10,'JPG');
    }
}