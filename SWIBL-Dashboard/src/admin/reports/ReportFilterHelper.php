<?php
namespace swibl\admin\reports;

use Presto\framework\html\SelectList;

class ReportFilterHelper {
    
    static function getSelectList($elementid, array $inarray, $header = "Select Option") {
        
        $selectList = new SelectList($elementid);
        $selectList->setHeader($header);
        foreach ($inarray as $value) {
            $selectList->addOption($value, $value);
        }
        return $selectList->toHtml();
    }
    
    static function getBootstrapSeasonDropdown($elementid, array $inarray, $header = "Select Option") {
        //btn btn-primary dropdown-toggle
        $html = "";
        $html .= "<div class=\"dropdown\">";
        $html .= "<button class=\"btn btn-primary dropdown-toggle\" type=\"button\" id=\"dropdownMenuLink\" " .
            " data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
        $html .= $header . " <span class=\"caret\"></span>";
        $html .= "</button>";
        $html .= "<ul class=\"dropdown-menu\" role=\"menu\">";
        foreach ($inarray as $obj) {
            $html .= "<li><a href=\"/admin/dashboard/reports/ListDivisionsBySeason?seasonid=" . $obj->seasonid . "\">" . $obj->season . "</a>";
        }
        $html .= "</ul>";
        $html .= "</div>";
        
        return $html;
    }
}