<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class ResultsTable
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($headerList, $dataList, $fieldsList, $sizeList, $alignList, $descriptionField){

        $table = '<style>
                    .header{
                        font-family: '.$this->pdf->font_medium.';
                        font-size: 10px;
                        line-height: 18px;
                    }
                    .line{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 10px;
                        line-height: 12px;
                    }
                    .description{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 10px;
                        line-height: 12px;
                    }
                    .spacer{
                        line-height: 10px;
                    }
                    .bordered{
                        border-bottom: 1px solid #E3E3E3;
                    }
                    </style>';

        $table .= '<table border="0" cellpadding="0px" cellspacing="0" width="100%"><thead><tr>';
        foreach ($headerList as $index => $header){
            $table .= '<td bgcolor="'.$this->pdf->colors['blue'].'" class="header" width="'.$sizeList[$index].'" align="'.$alignList[$index].'">'.$header.'</td>';
        }
        $table .= '</tr></thead><tr><td class="spacer"></td></tr>';


        foreach ($dataList as $rowIndex => $row){
            $table .= '<tr nobr="true" style="font-size:11px;">';
            foreach ($fieldsList as $index => $field){
                $table .= '<td class="line" width="'.$sizeList[$index].'"
            align="'.$alignList[$index].'"
            style="line-height: 15px;">'.$row[$field].'</td>';
            }
            $table .= '</tr>';
            if(isset($row[$descriptionField])){

                $descr = preg_replace('/<([0-9])/', '< $1', nl2br($row[$descriptionField]));

                $table .= '
                <tr nobr="true"><td class="spacer" colspan="4"></td></tr>
                <tr nobr="true"><td class="description" colspan="4">'.$descr.'</td></tr>';
            }

            $table .= '
            <tr nobr="true"><td class="spacer bordered" colspan="4"></td></tr>
            <tr nobr="true"><td class="spacer" colspan="4"></td></tr>';
        }


        $table .= '</table>';

        $this->pdf->writeHTML($table, true, false, false, false, '');

        $this->pdf->ln(20);
    }
}
