<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:27 PM
 */

namespace Solo\components;

use Solo\SoloReport;

class Header
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($numpages){
        
	$name = $this->pdf->data['Name'];
	
        if($numpages < $this->pdf::HEADER_START_PAGE || !$this->pdf::SHOW_HEADER || in_array($numpages, $this->pdf->cover_pages)){
            return;
        }

        if(isset($this->pdf->customBookmark[$this->pdf->currentSection])) {

            $bookmark = $this->pdf->customBookmark[$this->pdf->currentSection];

            $sectionTitle = $this->pdf->getText($bookmark['title']);

            $table = '<style>
                    .header{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 18px;
                        line-height: 24px;
                    }
                    .logo{
                        font-family: '.$this->pdf->font_medium.';
                        height: 35px;
                        border-bottom:1px solid #BEBEBE;
                    }
                    .info{
                        height: 35px;
                        border-bottom:1px solid #BEBEBE;
                    }
                    .bullet{
                        font-family: dejavusans;
                        color: '.$bookmark['color'].';
                    }
                    .spacer{
                        line-height: 13px;
                    }
                    .detailed{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 10px;
                        line-height: 15px;
                    }
                    .bold{
                        font-family: '.$this->pdf->font_medium.';
                        font-size: 10px;
                        line-height: 15px;
                    }
                    </style>';

            $table .= '
            <table class="header" border="0" cellpadding="0px" cellspacing="0">
                <tr>
                    <td class="logo" align="left" width="7%"><span>solo</span></td>
                    <td class="info" align="right" width="93%">
                    <span>'.$sectionTitle.'</span>';

            if($bookmark['addToTOC']){
                $table .= '
                    <span class="bullet">&nbsp;&bull;&nbsp;</span>
                    <span>'.($this->pdf->PageNo()-3).'</span>';
            }

            $table .= '</td>
                </tr>
                <tr><td class="spacer" colspan="3"></td></tr>';

            if($bookmark['addSecondLevel']) {
                $table .= '<tr>
                    <td class="detailed" align="left" width="70%"><span>'.$this->pdf->data['Name'].'</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Дата рождения '.$this->pdf->data['BDate'].'</span><br><span>Пол '.$this->pdf->data['Gender'].'</span></td>
                    <td class="bold" align="right" width="30%"><span>Дата исследования '.$this->pdf->data['RDate'].'</span><br><span>ID '.$this->pdf->data['ID'].'</span></td>
                </tr>';
            }


            $table .= '</table>';

            $this->pdf->writeHTML($table, false, false, true, false, '');

            $this->pdf->Image(PATH_IMAGES.'logo.png', 465, 773, 89, 31, 'PNG', '', 'T', false, 300, '', false, false, 0, 'L', false, false);

        }
    }
}
