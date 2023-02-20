<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\TableOfContents;

use Solo\SoloReport;

class TableOfContentsSection{
    public $pdf;
    public $cover;
    public $template;


    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->setTemplate();

        $this->pdf->TOCPageNumber = $this->pdf->PageNo() + 1;
    }

    private function setTemplate(){
        $template_name = $this->pdf->template_name;

        if($template_name === 'atlas'){
            $this->template = [
                'title-bg'      => false,
                'pattern'       => true,
                'bullet-color'  => '#cccccc',
                'line-color'    => 'black'
            ];
        }else if($template_name === 'emc'){
            $this->template = [
                'title-bg'      => true,
                'pattern'       => false,
                'bullet-color'  => '#0A5594',
                'line-color'    => '#0A5594'
            ];
        }
    }

    public function build(){

        $this->pdf->TOCOnCurrentPage = false;

        $this->pdf->addBookmark('adendum', false, false);
        $this->pdf->AddPage();
        $this->pdf->SetFont($this->pdf->font_light, '', 0);
        $this->pdf->SetY($this->pdf->GetY() - 30);


        foreach ($this->pdf->customBookmark as $bookmark){
            if($bookmark['addToTOC']) {
                $this->pdf->ln(10);
                $this->getLine($bookmark);
            }
        }

        $this->pdf->movePage($this->pdf->PageNo(), $this->pdf->TOCPageNumber);

        $this->pdf->TOCOnCurrentPage = true;

    }


    public function getLine($bookmark){

        $sectionTitle = $this->pdf->getText($bookmark['title']);

        $filler='.';
        $gap = ' ';
        $sectionTitle .= $gap;
        $pagesShifted = 2;
        $pagenum = $bookmark['page']+$pagesShifted;

        //write dot
        $this->pdf->SetFont('dejavusans', '', 18);
        $color = $this->pdf->utils->hex2Rgb($bookmark['color']);
        $this->pdf->SetTextColor($color[0], $color[1], $color[2]);
        $this->pdf->Cell(10, 0, '•', 0, 0, 'L', 0, '', 0);

        //write text
        $this->pdf->SetTextColor(0,0,0);
        $numwidth = $this->pdf->GetStringWidth('00000');
        $this->pdf->SetFont($this->pdf->font_regular, '', 18);
        $this->pdf->Write(0, $gap.$gap.$sectionTitle, '', false, 'L', false, 0, false, false, 0, $numwidth, '');


        //write filler
        $this->pdf->SetTextColor(207,207,207);
        $tw = $this->pdf->getPageWidth() - $this->pdf->getMargins()['left'] - $this->pdf->GetX();
        $fw = ($tw - $this->pdf->GetStringWidth($pagenum.$filler.$gap));
        $wfiller = $this->pdf->GetStringWidth($filler);
        if ($wfiller > 0) {
            $numfills = floor($fw / $wfiller);
        } else {
            $numfills = 0;
        }
        if ($numfills > 0) {
            $rowfill = str_repeat($filler, $numfills);
        } else {
            $rowfill = '';
        }
        $this->pdf->Cell($tw, 0, $rowfill, 0, 0, 'L', 0, '', 0);


        //write number
        $this->pdf->SetTextColor(0,0,0);
        $tw = $this->pdf->getPageWidth() - $this->pdf->getMargins()['left'] - $this->pdf->GetX();
        $this->pdf->Cell($tw, 0, $pagenum, 0, 1, 'R', 0, '', 0);

        $this->pdf->ln(20);
    }

}