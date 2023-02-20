<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:27 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class Table
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($headerList, $dataList, $fieldsList, $sizeList, $colorList, $alignList, $boldList = [], $iconList = [], $highlight = false, $tablePadding = 0, $iconSize = []){
        $this->pdf->SetFont($this->pdf->font_regular);

        $table = '<style>
                    .header{
                        font-family: '.$this->pdf->font_medium.';
                        line-height: 20px;
                        background: red;
                    }
                    .spacer{
                        font-family: '.$this->pdf->font_medium.';
                        line-height: 10px;
                    }
                    </style>';

        $table .= '
            <table border="0" cellpadding="'.$tablePadding.'px" cellspacing="0">';
        if($headerList){
            $table .= '<thead>
             <tr style="font-size:10px;">';
            if($highlight){
                $table .= '<td width="3px"></td>';
            }
            foreach ($headerList as $index => $header){
                $table .= '<td bgcolor="'.$this->pdf->colors['blue'].'" class="header" width="'.$sizeList[$index].'" align="'.$alignList[$index].'">'.$header.'</td>';
            }
            $table .= '
             </tr>
            </thead>
            <tr><td class="spacer"></td></tr>
        ';
        }

        foreach ($dataList as $item){
            $table .= '<tr nobr="true" style="font-size:11px;">';
            if($highlight){
                $table .= '<td width="3px" style="background-color: '.$this->pdf->colors[$item['color']].'"></td>';
            }
            foreach ($fieldsList as $index => $field){
                $color = $colorList[$index] ? $item[$colorList[$index]] : 'black';
                $bold = '';
                if(count($boldList)){
                    $bold = $boldList[$index] ? 'font-family: '.$this->pdf->font_medium.';' : '';
                }
                if($highlight) $color = 'black';
                $value = $field != null ? $item[$field] : '';
                if(isset($iconList[$index])){

                    if(strpos($item[$iconList[$index]], 'http') !== false){
                        $img_file = $item[$iconList[$index]];
                    }else{
                        $img_file = PATH_IMAGES.$item[$iconList[$index]];
                    }

                    if(count($iconSize)){
                        $width = $iconSize[0] ? 'width="'.$iconSize[0].'px"' : null;
                        $height = $iconSize[1] ? 'height="'.$iconSize[1].'px"' : null;
                    }else{
                        $width = 'width="8px"';
                        $height = 'height="11px"';
                    }
                    $value = '<img src="'.$img_file.'" '.$width.' '.$height.' />';
                }
                $table .= '<td width="'.$sizeList[$index].'"
                align="'.$alignList[$index].'"
                style="line-height: 15px; color: '.$color.';'.$bold.'">'.$value.'</td>';
            }
            $table .= '</tr>';
        }

        $table .= '</table>';

        $this->pdf->writeHTML($table, true, false, false, false, '');

    }
}