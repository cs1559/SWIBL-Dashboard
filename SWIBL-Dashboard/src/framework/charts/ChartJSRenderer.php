<?php
namespace Presto\framework\charts;

/*
 * ChartJSRenderer
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

class ChartJSRenderer implements ChartRendererInterface {
    
    var $chart;
    var $html;
    
    public function renderChart(Chart $chart)
    {
        $this->chart = $chart;
        $this->html = "";
        $this->readTemplate();

        $this->renderDataLabels();
        $this->renderDatasets();
        $this->renderBackgroundColors();
        return $this->html;
    }

    private function readTemplate() {
        $tname = $this->chart->getTemplate();
        $tmpl = __DIR__ . "/templates/chart-js/" . $tname;
        $myfile = fopen($tmpl, "r") or die("Unable to open file!");
        $html =  fread($myfile,filesize($tmpl));
        fclose($myfile);
        $this->html = $html;
        $this->replaceTag("element-id", $this->chart->getElementId());
    }

    private function renderDataLabels() {
        $data = $this->chart->getData();
        if (is_null($data)) {
            throw new MissingContextException("missing data");
        }
        $labels = $data->getLabels();
        $str = "'" . implode("','", $labels) . "'";
        $this->replaceTag("data-labels", $str);
    }
    
    private function renderDataSets() {
        $ds = $this->chart->getData()->getDatasets();
        foreach ($ds as $dataset) {
            $this->replaceTag("dataset-label",$dataset->getLabel());
            $data = $dataset->getDataValues();
            $str = implode(",", $data);
            $this->replaceTag("dataset-data",$str);
        }
    }
    
    private function renderBackgroundColors() {
        $ds = $this->chart->getData()->getDatasets();
        foreach ($ds as $dataset) {
            $this->replaceTag("dataset-label",$dataset->getLabel());
            $data = $dataset->getBackgroundColors();
            $str = "'" . implode("','", $data) . "'";
            $this->replaceTag("dataset-backgroundcolor",$str);
        }
    }
    
    
    private function replaceTag($tag, $value) {
        $searchTag = "/{tag:" . $tag . "}/";
        $this->html = preg_replace($searchTag, $value, $this->html);    
    }
}