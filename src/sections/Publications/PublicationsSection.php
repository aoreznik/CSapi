<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Publications;

use Solo\SoloReport;

class PublicationsSection{
    public $pdf;
    public $cover;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){

        $data = $this->pdf->data['Reference'];

        $this->pdf->addBookmark('publications', true, false);
        $this->pdf->AddPage();
        $this->pdf->SetY($this->pdf->GetY() - 30);


        $table = '<style>
                    .spacer{
                        line-height: 13px;
                    }
                    .publications{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 10px;
                        line-height: 12px;
                    }
                    </style>';

        $table .= '
            <table class="publications" border="0" cellpadding="0px" cellspacing="0">
            ';
        foreach ($data as $index => $pub){
            $table .= '
                <tr>
                    <td width="5%">'.($index+1).'.</td>
                    <td width="95%">'.$pub['Ref'].'</td>
                </tr>
                <tr><td class="spacer" colspan="3"></td></tr>
            ';
        }

        $table .= '
            </table>';

        $this->pdf->writeHTML($table, false, false, true, false, '');

    }


}