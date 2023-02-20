<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Results;

use Solo\SoloReport;

class ResultsFISHSection{
    public $pdf;
    public $cover;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){

        $data = $this->pdf->data['FISH'];

        if(count($data)){
            $data = $data[0];

            $this->pdf->addBookmark('resultsFISH');
            $this->pdf->AddPage();


            if(isset($data['FISHPic']) && count($data['FISHPic'])){

                $data = $data['FISHPic'][0];

                $imgW = 400;
                $imgH = 200;

                $path = PATH_IMAGES.'data/'.$data['FISHImg'];


                $html = '<img src="'.$path.'" width="'.$imgW.'" height="'.$imgH.'"> ';
                $html .= '<p><span style="font-size: 18px; font-family: '.$this->pdf->font_medium.';">'.$data['FISHMarker'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 16px; font-family: '.$this->pdf->font_regular.';">'.$data['FISHresult'].'</span></p>';
                $html .= '<p>'.$data['FISHresultDescr'].'</p>';
                $this->pdf->writeHTML($html, true, false, true, false, '');
                $this->pdf->ln(20);
            }

        }



    }

}