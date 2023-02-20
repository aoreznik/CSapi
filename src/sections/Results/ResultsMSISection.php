<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Results;

use Solo\SoloReport;

class ResultsMSISection{
    public $pdf;
    public $cover;


    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){


        $data = $this->pdf->data['MSI'];

        if(count($data)) {
            $data = $data[0];

            $this->pdf->addBookmark('resultsMSI');
            $this->pdf->AddPage();

            $this->pdf->titledDescription->set('МЕТОД ИССЛЕДОВАНИЯ', $data['MSIDescr'], true);
            $this->pdf->titledDescription->set('ЗАКЛЮЧЕНИЕ ПО РЕЗУЛЬТАТАМ АНАЛИЗА', $data['MSIResult'], true);
            $this->pdf->titledDescription->set('ИССЛЕДОВАНИЕ ВЫПОЛНЕНО:', $data['MSIContractor'], true);

        }

    }

}