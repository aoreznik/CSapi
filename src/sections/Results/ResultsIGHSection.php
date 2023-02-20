<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Results;

use Solo\SoloReport;

class ResultsIGHSection{
    public $pdf;
    public $cover;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;


        $this->build();
    }

    public function build(){

        $data = $this->pdf->data['IGH'];

        if(count($data)){
            $data = $data[0];

            $this->pdf->addBookmark('resultsIGH');
            $this->pdf->AddPage();


            if(isset($data['IGHPic']) && count($data['IGHPic'])){

                $data = $data['IGHPic'][0];

                $imgW = 400;
                $imgH = 200;

                $path = PATH_IMAGES.'data/'.$data['IHCImg'];


                $html = '<img src="'.$path.'" width="'.$imgW.'" height="'.$imgH.'"> ';
                $html .= '<p><span style="font-size: 18px; font-family: '.$this->pdf->font_medium.';">'.$data['IHCMarker'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 16px; font-family: '.$this->pdf->font_regular.';">'.$data['IHCresult'].'</span></p>';
                $html .= '<p>'.$data['IHCresultDescr'].'</p>';
                $this->pdf->writeHTML($html, true, false, true, false, '');
                $this->pdf->ln(20);
            }


        }



    }


}