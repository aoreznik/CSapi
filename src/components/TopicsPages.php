<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:23 PM
 */
namespace Solo\components;

use Solo\SoloReport;

class TopicsPages
{
    public $pdf;

    public function __construct(SoloReport $pdf)
    {
        $this->pdf = $pdf;
    }

    public function set($topics, $highlight = true){

        foreach ($topics as $topic){
            $this->pdf->AddPage();
            $this->pdf->pageTitle->set($topic['name']);

            //topic short description
            $previewTitle = isset($topic['preview_title']) ? $topic['preview_title'] : false;
            $this->pdf->pageShortDescription->set(isset($topic['preview']) ? $topic['preview'] : false, $highlight ? $topic['color'] : false, true, false, $previewTitle);

            //topic description
            $descriptionParagraphs = $this->pdf->utils->getParagraphs($topic['text']);
            foreach ($descriptionParagraphs as $paragraph) {
                $this->pdf->pageDescription->set($paragraph);
            }

            //topic snips table
            if(isset($topic['snips']) && count($topic['snips'])) {
                $headerList = [
                    $this->pdf->getText('gen'),
                    $this->pdf->getText('variant'),
                    $this->pdf->getText('genotypeYou')
                ];
                $fieldsList = ['gene', 'snip', 'genotype'];
                $sizeList = [33.33, 33.33, 33.33];
                $alignList = ['center', 'center', 'center'];
                $colorList = [null, null, null];

                $this->pdf->snipTable->set($topic, $headerList, $fieldsList, $sizeList, $colorList, $alignList,
                    'variants');
            }

            //topic snips table
            if(isset($topic['taxons']) && count($topic['taxons'])) {
                $headerList = [
                    $this->pdf->getText('bacteria_family'),
                    $this->pdf->getText('representation'),
                    $this->pdf->getText('sistesis_level')
                ];
                $fieldsList = ['taxon', 'percent', 'score'];
                $sizeList = [33.33, 33.33, 33.33];
                $alignList = ['left', 'center', 'center'];
                $colorList = [null, null, 'color'];

                $this->pdf->taxonTable->set($topic, $headerList, $fieldsList, $sizeList, $colorList, $alignList,
                    'raw');
            }

        }
    }
}