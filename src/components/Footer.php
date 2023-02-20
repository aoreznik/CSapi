<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:27 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class Footer
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($numpages){
        if($numpages < $this->pdf::FOOTER_START_PAGE || !$this->pdf::SHOW_FOOTER || in_array($numpages, $this->pdf->cover_pages)){
            return;
        }

        $table = '<style>
                    .spacer{
                        line-height: 13px;
                        border-top:1px solid #BEBEBE;
                    }
                    .disclaimer{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 7px;
                        line-height: 8px;
                    }
                    .contacts{
                        font-family: '.$this->pdf->font_medium.';
                        font-size: 10px;
                        line-height: 15px;
                    }
                    .email{
                        color: #5ED7F7;
                    }
                    </style>';

        $logo = '<img nobr="false" src="' . PATH_IMAGES.'logo.png' . '" width="89" height="31" alt="some" />';
        $table .= '
            <table border="0" cellpadding="0px" cellspacing="0">
                <tr><td class="spacer" colspan="3"></td></tr>
                <tr>
                    <td class="disclaimer" align="left" width="60%"><span>Предоставленная информация не имеет самостоятельного клинического (медицинского) значения. Принятие клинических решении является исключительнои компетенциеи квалифицированных специалистов специализированных медицинских учреждении</span></td>
                    <td class="contacts" align="right" width="17%">
                        <span class="phone">8 (800) 500-06-48</span>
                        <span class="email">solo@atlas.ru</span>
                    </td>
                    <td align="right" width="23%"></td>
                </tr>
            </table>';

        $this->pdf->writeHTML($table, false, false, true, false, '');

        $this->pdf->Image(PATH_IMAGES.'logo.jpg', 465, 773, 89, 31, 'JPG', '', 'T', false, 300, '', false, false, 0, 'L', false, false);

    }

}