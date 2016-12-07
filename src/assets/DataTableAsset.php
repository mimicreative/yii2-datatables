<?php
/**
 * @copyright Copyright (c) 2014 Serhiy Vinichuk
 * @license MIT
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 * @author Haqqi <me@haqqi.net>
 */

namespace mimicreative\datatables\assets;

use yii\web\AssetBundle;

class DataTableAsset extends AssetBundle {
  const STYLING_DEFAULT   = 'default';
  const STYLING_BOOTSTRAP = 'bootstrap';

  public $styling     = self::STYLING_DEFAULT;
  public $sourcePath  = '@vendor/datatables/datatables/media';

  public $depends = [
    'yii\web\JqueryAsset',
  ];

  public $js = [
    'js/jquery.dataTables.min.js'
  ];

  public function init() {
    parent::init();

    switch ($this->styling) {

      case self::STYLING_BOOTSTRAP:
        $this->depends[] = 'yii\bootstrap\BootstrapAsset';
        $this->depends[] = 'yii\bootstrap\BootstrapPluginAsset';
        $this->css[]     = 'css/dataTables.bootstrap.min.css';
        $this->js[]      = 'js/dataTables.bootstrap.min.js';
        break;

      case self::STYLING_DEFAULT:
        $this->css[] = 'css/jquery.dataTables.min.css';
        break;

      default;
    }
  }
}
