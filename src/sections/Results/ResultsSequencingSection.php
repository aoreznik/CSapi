<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Results;

use Solo\SoloReport;

class ResultsSequencingSection{
    public $pdf;
    public $cover;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){

        $data = $this->pdf->data;

        $this->pdf->addBookmark('resultsSequencing');
        $this->pdf->AddPage();

        $this->pdf->description->set('Секвенирование нового поколения (NGS) было проведено с целью определения точечных мутации, малых вставок и делеции (indel), а также протяженных амплификации и делеции. Картирование наиденных вариантов было проведено на основании геномнои сборки GRCh37. Анализ проводился с помощью набора реагентов Ion AmpliSeqTM Comprehensive Cancer Panel на платформе Ion Torrent S5. Порогом детекции мутации является 1% доли мутантного аллеля на фоне аллеля дикого типа, однако, распространеннои клиническои практикои является принятие во внимание мутации с частотои аллеля более 5%. Детектирование амплификации и делеции может проводится как для региона хромосомы (совокупности генов), так и для отдельного гена и отдельного региона гена. Ген считается амплифицированным в случае 2-кратного и более увеличения значении его покрытия по сравнению с референсными значениями для данного гена. Делеция определяется либо как гетерозиготная (уменьшение значении покрытия гена в два раза по сравнению с референсными значениями для данного гена), либо как гомозиготная (ген не обнаруживается).
Мутационная нагрузка расcчитана как отношение количества соматических несинонимичных мутации на общую длину целевои последовательности ДНК [2]. Рекомендуется принимать во внимание мутационную нагрузку, соответствующую 13,8 мутациям/МВ (13,8 мутации на 1 000 000 нуклеотидов) и более, что соответствует микросателлитно-нестабильному фенотипу опухоли (MSI-H).', true, 9);
	
	if($data['TMB'] == '-1'){
	    } else {
            $this->pdf->pageTitle->set('МУТАЦИОННАЯ НАГРУЗКА:', true,true,false,0);
            $this->pdf->description->set($data['TMB'].' мутации/МB', true, 10, 10);
	    }

        $this->pdf->pageTitle->set('СПИСОК ПРОАНАЛИЗИРОВАННЫХ ГЕНОВ', true,false,false,10);



        ///////////////////
        // TABLE SECTION //
        ///////////////////

        $list = $data['list'];
        $count = count($list);

        $cols = 8;
        $rows = ceil($count/$cols);

        $firstPageRows = 10;
        $maxRows = 17;

        $fullPages = floor(($rows)/$maxRows);

        $blockW = 62;
        $blockH = 32;
        $gap = 3;


        $blockIndex = 0;
        for($p=0;$p <= $fullPages;$p++){
            $rowsNum = $maxRows;
            if($p !== 0){
                $this->pdf->AddPage();
            }
            else{
                $rowsNum = min($maxRows, $firstPageRows);
            }

            $lineX = $this->pdf->GetX();
            $lineY = $this->pdf->GetY();


            for($r=0;$r<$rowsNum;$r++){
                for($c=0;$c<$cols;$c++){
                    if($blockIndex < $count) {

                        $value = $list[$blockIndex];
                        $fill = 0;

                        $checks = [
                            'uncertain'   => 1,
                            'significant'   => 2
                        ];
                        foreach ($data['CHECK'] as $check){
                            if($check['GeneSelect'] === $value){
                                $fill = $checks[$check['GeneType']];
                            }
                        }


                        $fillColor = $fill === 2 ? array(255, 114, 103) : array(238, 240, 239);

                        //Background
                        $this->pdf->Polygon(array(
                            $lineX + ($blockW * $c) + ($gap * $c), $lineY + ($blockH * $r) + ($gap * $r),
                            $lineX + ($blockW * $c) + ($gap * $c), $lineY + ($blockH * $r) + ($gap * $r) + $blockH,
                            $lineX + ($blockW * $c) + ($gap * $c) + $blockW, $lineY + ($blockH * $r) + ($gap * $r) + $blockH,
                            $lineX + ($blockW * $c) + ($gap * $c) + $blockW, $lineY + ($blockH * $r) + ($gap * $r)
                        ), 'F', '', $fillColor);

                        //Red fill
                        if ($fill === 1) {
                            $this->pdf->Polygon(array(
                                $lineX + ($blockW * $c) + ($gap * $c), $lineY + ($blockH * $r) + ($gap * $r),
                                $lineX + ($blockW * $c) + ($gap * $c), $lineY + ($blockH * $r) + ($gap * $r) + $blockH,
                                $lineX + ($blockW * $c) + ($gap * $c) + $blockW, $lineY + ($blockH * $r) + ($gap * $r)
                            ), 'F', '', array(255, 114, 103));
                        }

                        //Text
                        $this->pdf->writeHTMLCell(62,32,$lineX+($blockW*$c)+($gap*$c),$lineY+($blockH*$r)+($gap*$r),'<p style="font-family: '.$this->pdf->font_regular.';font-size: 10px;line-height: 32px;">'.$value.'</p>','',true,false, true,'C',false);
                    }

                    $blockIndex++;
                }

            }
        }



        ///////////////////
        // LEGEND SECTION //
        ///////////////////


        $this->pdf->SetX($this->pdf->getMargins()['left']);
        $this->pdf->ln(50);
        $table = '<style>
                    .spacer{
                        line-height: 13px;
                    }
                    .line{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 10px;
                        line-height: 12px;
                    }
                    </style>';

        $fill1 = '<img src="' . PATH_IMAGES.'fill1.png' . '" width="62" height="32" />';
        $fill2 = '<img src="' . PATH_IMAGES.'fill2.png' . '" width="62" height="32" />';
        $fill3 = '<img src="' . PATH_IMAGES.'fill3.png' . '" width="62" height="32" />';

        $table .= '
            <table border="0" cellpadding="0px" cellspacing="0">
                <tr>
                    <td width="17%">'.$fill1.'</td>
                    <td class="line" width="80%"><span style="line-height: 8px;"><br>клинически значимых мутации не обнаружено</span></td>
                    
                </tr>
                <tr><td class="spacer" colspan="2"></td></tr>
                <tr>
                    <td width="17%">'.$fill2.'</td>
                    <td class="line" width="80%"><span>обнаружена клинически значимая мутация с уровнем доказательности 3, 4, R2 или R3, либо мутация, являющаяся критерием включения в клиническое исследование, либо известныи онкогенныи вариант</span></td>
                    
                </tr>
                <tr><td class="spacer" colspan="2"></td></tr>
                <tr>
                    <td width="17%">'.$fill3.'</td>
                    <td class="line" width="80%"><span style="line-height: 8px;"><br>обнаружена клинически значимая мутация с уровнем доказательности 1, 2 или R1</span></td>
                    
                </tr>
            </table>';

        $this->pdf->writeHTML($table, false, false, false, false, '');


        $this->pdf->ln(25);

        $style = '<style>
                    .title{
                        font-family: '.$this->pdf->font_medium.';
                        font-size: 10px;
                        line-height: 12px;
                    }
                    .line{
                        font-family: '.$this->pdf->font_regular.';
                        font-size: 10px;
                        line-height: 5px;
                    }
                    span{
                        font-family: '.$this->pdf->font_medium.';
                    }
                    </style>';
        $this->pdf->description->set($style.'
            <p class="title">ОТЧЕТ О КАЧЕСТВЕ СЕКВЕНИРОВАНИЯ</p>
            <p class="line">Средняя кратность покрытия областеи: <span>'.$data['Coverage'].'</span></p>
            <p class="line">Доля целевых областеи с кратностью покрытия более x20: <span>'.$data['HighCov'].'</span></p>
            <p class="line">Количество целевых областеи с кратностью покрытия менее x20: <span>'.$data['LowCov'].'</span></p>
            <p class="line">Клинически значимые области ("горячие точки") с кратностью покрытия менее x20: <span>'.$data['Hotspots'].'</span></p>
        ', true, 10, 20, true);






        $this->pdf->AddPage();

        $this->pdf->description->set('В данном разделе приводятся все обнаруженные соматические варианты. Также в случае обнаружения могут быть приведены варианты, ассоциированные с наследственными онкологическими синдромами. Вначале в алфавитном порядке приведены клинически значимые варианты, для которых даны описания. Далее в алфавитном порядке приведены варианты с неизвестнои клиническои значимостью.', true);

        $this->pdf->pageTitle->set('КЛИНИЧЕСКИ ЗНАЧИМЫЕ ВАРИАНТЫ',true,true,false);


        $headerList = [
            'Ген (экзон)',
            'Вариант',
            'Кратность покрытия',
            'Доля мутантного аллеля',
        ];
        $fieldsList = ['SNVGene', 'gPos', 'PosCoverage', 'MAF'];
        $sizeList = ['20%', '20%', '30%', '30%'];
        $alignList = ['left', 'left', 'center', 'center'];
        $descriptionField = 'VariantDescr';

        foreach ($data['SignSNV'] as &$topic){
            $topic['gPos'] = $topic['gPos'] .'<br>' .$topic['cPos'] .'<br>' .$topic['pPos'];
        }
        $this->pdf->description->set('Однонуклеотидные варианты и вставки/делеции (SNV, indel)', true, 12, 20,0,$this->pdf->font_medium);
        $this->pdf->resultsTable->set($headerList, $data['SignSNV'], $fieldsList, $sizeList, $alignList, $descriptionField);

        $headerList = [
            'Ген (экзон)',
            'Вариант',
            'Кратность покрытия',
            'Изменение копийности',
        ];
        $fieldsList = ['CNVGene', 'CNVVar', 'CNVCoverage', 'CNValternation'];
        $descriptionField = 'CNVDescription';
        $this->pdf->description->set('Варианты числа копий (CNV)', true, 12, 20,0,$this->pdf->font_medium);
        $this->pdf->resultsTable->set($headerList, $data['SignCNV'], $fieldsList, $sizeList, $alignList, $descriptionField);




	$this->pdf->AddPage();
        $this->pdf->pageTitle->set('ВАРИАНТЫ С НЕИЗВЕСТНОЙ КЛИНИЧЕСКОЙ ЗНАЧИМОСТЬЮ',true,true,false);


        $headerList = [
            'Ген (экзон)',
            'Вариант',
            'Кратность покрытия',
            'Доля мутантного аллеля',
        ];
        $fieldsList = ['SNVGene', 'gPos', 'PosCoverage', 'MAF'];
        $sizeList = ['20%', '20%', '30%', '30%'];
        $alignList = ['left', 'left', 'center', 'center'];
        $descriptionField = 'VariantDescr';

        foreach ($data['InSignSNV'] as &$topic){
            $topic['gPos'] = $topic['gPos'] .'<br>' .$topic['cPos'] .'<br>' .$topic['pPos'];
        }
        $this->pdf->description->set('Однонуклеотидные варианты и вставки/делеции (SNV, indel)', true, 12, 20,0,$this->pdf->font_medium);
        $this->pdf->resultsTable->set($headerList, $data['InSignSNV'], $fieldsList, $sizeList, $alignList, $descriptionField);




        $headerList = [
            'Ген (экзон)',
            'Вариант',
            'Кратность покрытия',
            'Изменение копийности',
        ];
        $fieldsList = ['CNVGene', 'CNVVar', 'CNVCoverage', 'CNValternation'];
        $descriptionField = 'CNVDescription';
        $this->pdf->description->set('Варианты числа копий (CNV)', true, 12, 20,0,$this->pdf->font_medium);
        $this->pdf->resultsTable->set($headerList, $data['InSignCNV'], $fieldsList, $sizeList, $alignList, $descriptionField);



    }



    //////////
    // DATA //
    //////////

    public function getProfile(){
//        return $this->pdf->data['profile'];
    }


}
