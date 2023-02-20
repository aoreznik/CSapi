<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class Cover
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($imgPath){
        $this->pdf->AddPage();

        $pageWidth = $this->pdf->getPageWidth();
        $pageHeight = $this->pdf->getPageHeight();

        $bMargin = $this->pdf->getBreakMargin();
        $auto_page_break = $this->pdf->getAutoPageBreak();
        $this->pdf->SetAutoPageBreak(false, 0);
        $img_file = PATH_IMAGES.$imgPath;
        $this->pdf->Image($img_file, 0, 0, $pageWidth, $pageHeight, '', '', '', false, $this->pdf->image_quality, '', false, false, 0);
        $this->pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->pdf->setPageMark();

        $this->pdf->cover_pages[] = $this->pdf->PageNo();//add page to covers list
    }
}