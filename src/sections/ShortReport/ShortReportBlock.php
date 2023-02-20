<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/10/17
 * Time: 12:29 PM
 */

namespace src\blocks\ShortReport;

use src\AtlasReport;

class ShortReportBlock{
    public $pdf;
    public $template;

    //////////
    // Data //
    //////////

    public $systems;

    public function __construct(AtlasReport $pdf)
    {
        $this->pdf = $pdf;

        if($this->pdf->isSectionNeeded('shortReport')) {
            $this->systems = $this->getSystems();

            $this->setTemplate();
            $this->build();
        }
        $this->pdf->addon->set('shortReport');
    }

    private function setTemplate(){
        $template_name = $this->pdf->template_name;

        if($template_name === 'atlas'){
            $this->template = [
                'cover'         => 'bg/7.jpg',
            ];
        }else if($template_name === 'emc'){
            $this->template = [
                'cover'         => 'bg/emc/emc_section.jpg',
            ];
        }
    }

    public function build(){
        //block cover page
        $this->pdf->addBookmark('shortReport');
        $this->pdf->cover->set($this->template['cover']);
        $this->pdf->coverTitle->set('shortReport');
        $this->pdf->coverSubtitle->set('shortReportAbout');

        $this->pdf->addHTMLTOC();


        $allSystems = $this->systems['all'];
        $filledSystems = $this->systems['filled'];

        foreach ($filledSystems as $systemId => $system){
            $this->pdf->AddPage();
            if($this->pdf->template['show-icons']){
                $this->pdf->pageTitle->set($allSystems[$systemId]['ru'], true, 'systems/'.$systemId.'.png');
            }else{
                $this->pdf->pageTitle->set($allSystems[$systemId]['ru']);
            }

            $this->pdf->pageDescription->set($allSystems[$systemId]['descr']);
            $this->pdf->pageSubtitle->set('yourResults', false);


            $systemNameVersion = $this->pdf->data['profile']['locale'] === 'ru' ? 'gen' : 'ru';
            $systemNameGen = mb_convert_case($allSystems[$systemId][$systemNameVersion], MB_CASE_LOWER, "UTF-8");

            if(!isset($system['risks'])) {
                $this->pdf->pageDescription->set($this->pdf->getText('typicalRisks') . ' ' . $systemNameGen.'.');
            }else{
                $this->pdf->pageDescription->set('yourResultsInfo', false, false, 10);

                foreach ($system['risks'] as $risk){
                    $riskTitle = $this->pdf->getText('riskGetting').' '.($risk['title_gen'] ? $risk['title_gen'] : $risk['title']);
                    $itemColor = $this->pdf->colors[$risk['color']];

                    $riskLine = '<div style="font-family: '.$this->pdf->font_medium.';font-size: 11px;"><span style="font-family: \'dejavusans\'; color: '.$itemColor.';font-size: 16px;">&nbsp;&bull;&nbsp;</span>'.$riskTitle.'</div>';
                    $this->pdf->writeHTML($riskLine, true, false, true, false, '');
                    $this->pdf->ln(5);
                }
                $this->pdf->ln(10);
            }

            if(!isset($system['monogens'])) {
                $this->pdf->pageDescription->set($this->pdf->getText('noMono') . ' ' . $systemNameGen . '.');
            }else{
                $this->pdf->pageDescription->set($this->pdf->getText('followingHereditaryDiseases') . ' ' . $systemNameGen . ':', true, false, 10);

                foreach ($system['monogens'] as $monogen){

                    $itemColor = $this->pdf->colors['orange'];

                    $monogenLine = '<div style="font-family: '.$this->pdf->font_medium.';font-size: 11px;"><span style="font-family: \'dejavusans\'; color: '.$itemColor.';font-size: 16px;">&nbsp;&bull;&nbsp;</span>'.$monogen['title'].'</div>';
                    $this->pdf->writeHTML($monogenLine, true, false, true, false, '');
                    $this->pdf->ln(5);
                }
            }
        }


    }



    //////////
    // DATA //
    //////////

    public function getSystems(){
        $systems = [];
        $systemsList = [];

        $risks = isset($this->pdf->data['risks']) ? $this->pdf->data['risks'] : [];
        $monogens = isset($this->pdf->data['monogens']) ? $this->pdf->data['monogens'] : [];

        $risksHighGroups = [5,4];
        $risksGroupProperties = [
            5   => 'red',
            4   => 'orange',
            3   => 'orange-light',
            2   => 'green-light',
            1   => 'green',
        ];

        foreach($this->pdf->data['systems'] as $system)
        {
            $currentSystem = $system['id'];
            foreach($risks as $risk){
                if($risk['organ_system'] === $currentSystem
                    && in_array($risk['group'], $risksHighGroups)){
                    $risk['color'] = $risksGroupProperties[$risk['group']];
                    $systems[$currentSystem]['risks'][] = $risk;
                }
            }

            foreach($monogens as $monogen){
                if($monogen['organ_system'] === $currentSystem
                    && $monogen['status'] > 1){
                    $systems[$currentSystem]['monogens'][] = $monogen;
                }
            }

            $systemsList[$currentSystem] = $system;

        }


//        foreach ($groups as & $group){
//            usort($group, function ($a, $b) {
//                return $a['score'] > $b['score'];
//            });
//        }

//        $this->pdf->log($systems);

        return [
            'all'       => $systemsList,
            'filled'    => $systems
        ];
    }



}