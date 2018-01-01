<?php

require '..\..\vendor\autoload.php';

require "../../core/html/HtmlElement.php";
require "../../core/html/TextArea.php";
require "../../core/html/Link.php";
require "../../core/html/Html.php";
require "../../core/html/Input.php";
require "../../core/html/SelectOption.php";
require "../../core/html/SelectList.php";


use Presto\framework\html\Html;
use Presto\framework\html\SelectList;

echo Html::getTextArea("textarea1", "This is a test", 5, 60);
echo Html::getLink("http://www.yahoo.com","Yahooooo!");
echo Html::getInputElement("inputtext","Hello World","text", 75,75);

$obj = new SelectList("testelement");
$obj->setHeader("-- Select Option --");
$obj->setAttribute("class","input");
$obj->setAttribute("onChange","javascript:alert('hello world');");
$obj->addOption("test","Test Option");
$obj->addOption("test 1","Test Option 1", true);
$obj->addOption("test 2","Test Option 2");
echo $obj->toHtml();

$recipient = array("cs1559@sbcglobal.net","chris@swibl-baseball.org");
			foreach ($recipient as $to) {
				echo $to;
			}


?>