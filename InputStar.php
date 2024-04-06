<?php if (!defined('PmWiki')) exit();
/**
  Input star control for PmWiki
  Written by (c) Petko Yotov 2024   www.pmwiki.org/petko
  License: MIT
  
  This extension creates (:input star name:) element that outputs
  a group of radio buttons styled with stars instead of circles.
*/

$RecipeInfo['InputStar']['Version'] = '2024-04-06a';

SDVA($InputTags['star'], [
  ':fn' => 'InputStar',
  ':args' => ['name', 'value'],
  ':checked' => 'checked',
]);

function InputStar($pagename, $type, $args) {
  global $InputValues, $InputTags, $InputLabelFmt;
  $InputLabelFmtOrig = $InputLabelFmt;
  $InputLabelFmt = trim($InputLabelFmt);
  static $seen = 0;
  
  if(!$seen++) {
    extAddResource('inputstar.css');
  }

  if (!is_array($args)) $args = ParseArgs($args, '(?>([\\w-]+)[=])');
  
  $posnames = $InputTags['star'][':args'];
  
  while (count($posnames) > 0 && @$args[''] && count($args['']) > 0) {
    $n = array_shift($posnames);
    if (!isset($args[$n])) $args[$n] = array_shift($args['']);
  }
  
  $checkedvalue = intval(@$args['value']);
  
  unset($args['checked'], $args['id']);
  $args['label'] = "";
  
  $out = "";
  for($i=5; $i>0; $i--) {
    $args['value'] = $args['title'] = $i;
    if($i == $checkedvalue) {
      $args['checked'] = 'checked';
    }
    else {
      unset($args['checked']);
    }
    $out .= InputToHTML($pagename, 'radio', $args, $opt);
  }
  $InputLabelFmt = $InputLabelFmtOrig;
  return Keep("<span class='pminputstars'>$out</span>");
}
