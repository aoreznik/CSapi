<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Results;

use Solo\SoloReport;

class ResultsPatomorphoSection{
    public $pdf;
    public $cover;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){

        $data = $this->pdf->data['Path'];

        if(count($data)){
            $data = $data[0];

            $this->pdf->addBookmark('resultsPatomorpho');
            $this->pdf->AddPage();


            if(isset($data['PathC'])){
                $this->pdf->pageTitle->set('ПАТОМОРФОЛОГИЧЕСКОЕ ЗАКЛЮЧЕНИЕ:', true, true, true);
                $this->pdf->description->set($data['PathC']);
            }

            if(isset($data['MacrC'])) {
                $this->pdf->pageTitle->set('МАКРОСКОПИЧЕСКОЕ ОПИСАНИЕ:', true, true, true);
                $this->pdf->description->set($data['MacrC']);
            }

            if(isset($data['MicrC'])) {
                $this->pdf->pageTitle->set('МИКРОСКОПИЧЕСКОЕ ОПИСАНИЕ:', true, true, true);
                $this->pdf->description->set($data['MicrC']);
            }

            if(isset($data['PathContractor'])) {
                $this->pdf->pageTitle->set('ИССЛЕДОВАНИЕ ВЫПОЛНЕНО:', true, true, true);
                $this->pdf->description->set($data['PathContractor']);
            }


            if(count($data['PathQ'])){

                $this->pdf->AddPage();

                $imgW = 400;
                $imgH = 200;

                foreach ($data['PathQ'] as $image){
                    $path = PATH_IMAGES.'data/'.$image['PathImg'];


                    $html = '<img src="'.$path.'" width="'.$imgW.'" height="'.$imgH.'"> ';
                    $html .= '<p>'.$image['PathImgDescr'].'</p>';
                    $this->pdf->writeHTML($html, true, false, true, false, '');
                    $this->pdf->ln(20);
                }
            }


        }

    }


}