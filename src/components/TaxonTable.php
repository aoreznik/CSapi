<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:27 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class TaxonTable
{
    public $pdf;
    public $headerList;
    public $fieldsList;
    public $sizeList;
    public $colorList;
    public $alignList;

    public $bgColor = '#F4F4F4';

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($topic, $headerList, $fieldsList, $sizeList, $colorList, $alignList, $variantsText){
        $this->headerList = $headerList;
        $this->fieldsList = $fieldsList;
        $this->sizeList = $sizeList;
        $this->colorList = $colorList;
        $this->alignList = $alignList;

        $this->pdf->SetFont($this->pdf->font_regular);


        $table = '<style>
                    .snips{
                        font-family: '.$this->pdf->font_light.';
                    }
                    .snips-line{
                        height: 20px;
                        line-height:20px;
                        font-size: 11px;
                    }
                    .snips-header{
                        height: 20px;
                        line-height:20px;
                        font-size: 9px;
                    }
                    .snips-title{
                        font-size:22px;
                        font-family: '.$this->pdf->font_regular.';
                    }
                    .snips-title-ln{
                        height: 20px;
                    }
                    </style>';

        $table .= '
            <table border="0" cellpadding="0" cellspacing="0">
            
            <tr>
                <td colspan="9" class="snips-title">'.$this->pdf->getText($variantsText).'</td>
            </tr>
            <tr>
                <td colspan="9" class="snips-title-ln"></td>
            </tr>
            <tr class="snips-header">';

        $table = $this->formTableHeaderCols($table);
        $table .= '</tr>';

        foreach ($topic['taxons'] as $index => $taxon){
            $table .= '<tr nobr="true" class="snips-line">';
            $table = $this->formTableCols($table, $taxon, $index);
            $table .= '</tr>';
        }

        $table .= '</table>';

        $this->pdf->writeHTML($table, true, false, true, false, '');

    }

    public function formTableHeaderCols($table){
        foreach ($this->headerList as $index => $header){
            $paddingStart = $index === 0 ? '&nbsp;&nbsp;' : '';
            $paddingEnd = $index === count($this->headerList)-1 ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '';

            $table .= '<td
            width="'.$this->getCellWidth($this->sizeList[$index]).'"
            align="'.$this->alignList[$index].'"
            style="border-bottom:1px solid #f8f8f8;">'.$paddingStart.$header.$paddingEnd.'</td>';
        }
        return $table;
    }

    public function formTableCols($table, $item, $rowIndex){
        foreach ($this->fieldsList as $index => $field) {
            $paddingStart = $index === 0 ? '&nbsp;&nbsp;' : '';
            $paddingEnd = $index === count($this->fieldsList)-1 ? '&nbsp;&nbsp;&nbsp;' : '';
            $color = $this->colorList[$index] ? $item[$this->colorList[$index]] : 'black';
            $bgColor = $rowIndex % 2 === 0 ? $this->bgColor : '';
            $value = $field != null ? $item[$field] : '';

            $table .= '<td bgcolor="'.$bgColor.'" width="'.$this->getCellWidth($this->sizeList[$index]).'"
                            align="' . $this->alignList[$index] . '"
                            style="color: ' . $color . '">' . $paddingStart . $value . $paddingEnd . '</td>';
        }
        return $table;
    }

    public function getCellWidth($cellAbsPercent){
        return 100 / 100 * $cellAbsPercent . '%';
    }

}