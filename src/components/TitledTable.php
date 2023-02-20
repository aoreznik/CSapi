<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class TitledTable
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($title, $highlightTitle, $highlightValue, $description){

        $title = mb_convert_case($title, MB_CASE_UPPER, "UTF-8");

        $table = '<style>
                    .header{
                        font-family: '.$this->pdf->font_medium.';
                        font-size: 11px;
                        line-height: 18px;
                    }
                    span{
                        font-family: '.$this->pdf->font_medium.';
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
                    </style>';

        $table .= '
            <table nobr="true" border="0" cellpadding="0px" cellspacing="0" width="100%">
                <thead><tr><td bgcolor="'.$this->pdf->colors['blue'].'" class="header" colspan="3">'.$title.'</td></tr></thead>
                <tr><td class="spacer" colspan="2"></td></tr>
                <tr>
                    <td class="description" width="17%">'.$highlightTitle.'<br><span>'.$highlightValue.'</span></td>
                    <td class="description" width="83%">'.$description.'</td>
                </tr>
            </table>';

        $this->pdf->writeHTML($table, true, false, false, false, '');

        $this->pdf->ln(20);
    }
}