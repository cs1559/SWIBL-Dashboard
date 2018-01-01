<?php
use Presto\framework\charts\Chart;
use Presto\framework\charts\ChartRenderer;
use Presto\framework\charts\Data;
use Presto\framework\charts\DataItem;
use Presto\framework\charts\DataSet;

require "Chart.php";
require "Data.php";
require "DataItem.php";
require "DataSet.php";
require "ChartRenderer.php";
require "ChartRendererInterface.php";
require "ChartJSRenderer.php";


/**
 * 
 *                                             backgroundColor: [{tag:dataset-bkgcolor}],
                                            borderColor: [{tag:dataset-bordercolor}],
                                            
                                           
 */
$chart = new Chart();

$ds = new DataSet();
$ds->setLabel("Number of Teams");
$ds->addDataItem(new DataItem("7U", 30));
$ds->addDataItem(new DataItem("8U", 22));
$ds->addDataItem(new DataItem("9U", 18));
$ds->addDataItem(new DataItem("10U", 28));
$ds->addDataItem(new DataItem("11U", 30));
$ds->addDataItem(new DataItem("12U", 25));
$ds->addDataItem(new DataItem("13U", 18));
$ds->addDataItem(new DataItem("14U", 33));

$data = new Data();
$data->addLabel("7U");
$data->addLabel("8U");
$data->addLabel("9U");
$data->addLabel("10U");
$data->addLabel("11U");
$data->addLabel("12U");
$data->addLabel("13U");
$data->addLabel("14U");
$data->addDatasets($ds);

$chart->setData($data);

$renderer = new ChartRenderer("Chart.js");
$renderer->render($chart);

