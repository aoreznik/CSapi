<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class Addon
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($sectionName, $afterTOC = true){
        if(isset($this->pdf->data['addons'][$sectionName])){
            $addon = $this->pdf->data['addons'][$sectionName];

            if($afterTOC){
                $this->pdf->addBookmark($addon['section_title'], 0, true);
            }
            for($i=0;$i<$addon['pages_count'];$i++){
                $this->pdf->AddPage();
            }
        }
    }
}