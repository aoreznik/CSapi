<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Intro;

use Solo\SoloReport;

class IntroSection{
    public $pdf;
    public $cover;

    //////////
    // Data //
    //////////

    public $profile;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){

        $this->pdf->AddPage();

        $data = $this->pdf->data;

        $report_subname = 'Solo Комплекс';
        $report_name = 'Отчет о молекулярно-<br>генетическом исследовании';

        $user_name = $data['Name'];
        $user_id = $data['ID'];
        $user_birth = $data['BDate'];
        $user_sample_id = $data['SID'];
        $user_gender = $data['Gender'];
        $user_date_receive = $data['RDate'];
        $user_date_analysis = $data['CDate'];
        $user_sample_source = $data['SSource'];
        $user_diagnosis = $data['Diagnosis'];

        $intro_descr = 'Целью проводимого исследования является анализ биомаркеров, ассоциированных с клинико-патологическими характеристиками и потенциальнои эффективностью терапии '.$data['BMark'];
//        $intro_descr .= '<br>В рамках исследования проанализированы XXX генов, в том числе следующие: XXXXX. Интерпретация наиденных генетических вариантов и биомаркеров выполняется на основании собственнои базы знании, включающеи международные клинические руководства, а также результаты клинических и научных исследовании.';
        $disclaim = 'Отчет предназначен для использования специалистами в области клиническои онкологии.';

        $this->pdf->setY(40);


        $this->pdf->SetFont($this->pdf->font_medium, '', 20);
        $this->pdf->MultiCell(0, 0, $report_subname, 0, 'L', 0, 1, '', '', true, 0, true);

        $this->pdf->ln(5);

        $this->pdf->SetFont($this->pdf->font_medium, '', 30);
        $this->pdf->MultiCell(0, 0, $report_name, 0, 'L', 0, 1, '', '', true, 0, true);

        $this->pdf->ln(20);

        $this->pdf->SetFont($this->pdf->font_medium, '', 12);
        $this->pdf->MultiCell(0, 0, $user_name.'<br>ID '.$user_id, 0, 'L', 0, 1, '', '', true, 0, true);

        $this->pdf->ln(20);

        $table = '<style>
                    .table{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 12px;
                        line-height: 31px;
                    }
                    .value{
                        font-family: '.$this->pdf->font_medium.';
                        line-height: 15px;
                    }
                    .spacer{
                        line-height: 35px;
                    }
                    .border{
                        border-bottom: 1px solid #bebebe;
                    }
                    </style>';

        $table .= '
            <table class="table" border="0" cellpadding="0px" cellspacing="0">
                <tr>
                    <td width="40%">Дата рождения <span class="value">'.$user_birth.'</span></td>
                    <td width="60%">Идентификатор образца <span class="value">'.$user_sample_id.'</span></td>
                </tr>
                <tr>
                    <td width="40%">Пол <span class="value">'.$user_gender.'</span></td>
                    <td width="60%">Дата забора образца <span class="value">'.$user_date_receive.'</span></td>
                </tr>
                <tr>
                    <td width="40%">Дата исследования <span class="value">'.$user_date_analysis.'</span></td>
                    <td width="60%">Источник биоматериала <span class="value">'.$user_sample_source.'</span></td>
                </tr>
                <tr>
                    <td colspan="2" width="100%" class="spacer border"></td>
                </tr>
                <tr>
                    <td colspan="2" width="100%" class="spacer"></td>
                </tr>
            </table>';

        $this->pdf->writeHTML($table, false, false, true, false, '');


        $this->pdf->SetFont($this->pdf->font_regular, '', 12);
        $this->pdf->MultiCell(0, 0, 'Диагноз при обращении:', 0, 'L', 0, 1, '', '', true, 0, true);

        $this->pdf->SetFont($this->pdf->font_medium, '', 12);
        $this->pdf->MultiCell(0, 0, $user_diagnosis, 0, 'L', 0, 1, '', '', true, 0, true);

        $this->pdf->ln(20);

        $this->pdf->titledDescription->set('Цель исследования', $intro_descr, true, true, true);


        $this->pdf->setY($this->pdf->getPageHeight() - 120);

        $this->pdf->SetFont($this->pdf->font_medium, '', 12);
        $this->pdf->Write(0,$disclaim, '', 0, 'L', 0);
    }



}