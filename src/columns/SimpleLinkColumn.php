<?php

namespace mimicreative\datatables\columns;

use yii\base\Object;
use yii\web\JsExpression;

/**
 * Class SimpleLinkColumn
 * 
 * To use this, you must have data (AJAX processed) with structure:
 * 
 * {
 *    content: 'xyz',
 *    url: "/to/somewhere"
 * }
 * 
 * Because the data will still can be sorted or filtered.
 * 
 * @package mimicreative\datatables\columns
 * @author Haqqi <me@haqqi.net>
 */
class SimpleLinkColumn extends Object {
  public $data;
  public $render;
  public $title;
  public $searchable = false;
  public $orderable = false;

  public function init() {
    $this->render = new JsExpression('
      function(data, type, row, meta) {
        if(type === "display") {
          var links = jQuery("<div/>");
          
          var link = jQuery("<a>" + data.content + "</a>");
          link.attr("href", data.url);
          
          links.append(link);
          
          return links.html();
        }
        
        return data.content;
      }
    ');
  }
}