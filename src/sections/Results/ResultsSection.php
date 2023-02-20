<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace Solo\sections\Results;

use Solo\SoloReport;

class ResultsSection{
    public $pdf;
    public $cover;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;

        $this->build();
    }

    public function build(){

        $data = $this->pdf->data['TABLE'];

        //temp data
        $topic = [
            'title' => 'ЧЧЧЧЧЧЧЧЧЧЧЧЧ',
            'subtitle' => 'Препарат эффективен в связи с наличием XXXXX в гене XXXXXX.',
            'gene' => 'Активирующие мутации EGFR',
            'descr' => 'Подтверждение мутации T790M EGFR необходимо для назначения препарата Осимертиниб, которыи является стандартом лечения пациентов после прогрессирования после лечения ингибиторами ТК EGFR (NCCN, ESMO, ASCO). Частота мутации T790M составляет около 50% среди больных на момент прогрессии после лечения ТКИ EGFR и 5% перед началом лечения. Клинические исследования II фазы (AURA, AURA2) продемонстрировали эффективность препарата у пациентов (201 и 210 в AURA и AURA2 соответственно) с мутациеи T790M гена EGFR, с подтвержденнои прогрессиеи заболевания после терапии ТКИ EGFR. Частота объективного ответа среди двух исследовании составила 59%, частота полного ответа — 0,5%, частота частичного ответа —59%. Для большинства пациентов (96%) у которых достигнут объективныи ответ, длительность ответа варьировала от 1,1 до 5,6 месяцев при медиане длительности наблюдения 4,1 месяцев (4,0 AURA, 4,2 AURA2). В отдельнои группе пациентов при оценке эффективности препарата с эскалациеи дозы, частота объективного ответа была достигнута у 51%пациента с медианои длительности ответа 12,4 месяца. [2, 3]',
            'table' =>  [
                [
                    'key'  => 'результат',
                    'value'  => 'T790M',
                ],
                [
                    'key'  => 'метод определения',
                    'value'  => 'NGS',
                ],
                [
                    'key'  => 'уровень доказательности',
                    'value'  => '1',
                ],
                [
                    'key'  => 'клинические руководства',
                    'value'  => 'NCCN, ASCO, ESMO, RUSSCO',
                ]
            ]
        ];

        $this->pdf->addBookmark('results');

        foreach ($data as $topic) {
            $this->pdf->AddPage();

            $this->pdf->pageTitle->set($topic['Drug'], true, 1, false, 10, 5, 'green');
            $this->pdf->description->set($topic['DDescr'], true);


            $this->pdf->pageTitle->set($topic['GADescr'], true);

            $table =  [
                [
                    'key'  => 'результат',
                    'value'  => $topic['GA'],
                ],
                [
                    'key'  => 'метод определения',
                    'value'  => $topic['Meth'],
                ],
                [
                    'key'  => 'уровень доказательности',
                    'value'  => isset($topic['LoE']) ? $topic['LoE'] : '-',
                ],
                [
                    'key'  => 'клинические руководства',
                    'value'  => implode(', ', $topic['Glines'])
                ]
            ];

            $headerList = null;
            $fieldsList = ['key', 'value'];
            $sizeList = ['32%', '30%'];
            $alignList = ['left', 'left'];
            $boldList = [false, true];
            $colorList = [null, null];

            $this->pdf->table->set($headerList, $table, $fieldsList, $sizeList, $colorList, $alignList, $boldList);

            $topic['DDescrLong'] = str_replace("\n", ' ', $topic['DDescrLong']);
            $this->pdf->description->set($topic['DDescrLong'], true);

        }


    }


}