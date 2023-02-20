<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:26 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class TitledDescription
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($title, $description, $isCustom = true, $uppercase = true, $fill = true, $fontSize = 14, $offset = 20){
        if(!$isCustom) $description = $this->pdf->getText($description);


        if($uppercase) {
            $title = mb_convert_case($title, MB_CASE_UPPER, "UTF-8");
        }

        $bgcolor = null;
        if($fill){
            $bgcolor = 'bgcolor="'.$this->pdf->colors['blue'].'"';
        }

        $table = '<style>
                    .header{
                        font-family: '.$this->pdf->font_medium.';
                        font-size: '.$fontSize.'px;
                        line-height: 20px;
                    }
                    .description{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 12px;
                        line-height: 16px;
                    }
                    .spacer{
                        line-height: 10px;
                    }
                    </style>';

        $table .= '
            <table nobr="false" border="0" cellpadding="0px" cellspacing="0" width="100%">
                <thead><tr><td '.$bgcolor.' class="header" colspan="3">'.$title.'</td></tr></thead>
                <tr><td class="spacer"></td></tr>
                <tr>
                    <td class="description" align="left" width="100%">'.$description.'</td>
                </tr>
            </table>';

        $this->pdf->writeHTML($table, true, false, false, false, '');

        $this->pdf->ln($offset);
    }
}