<?php

namespace mimicreative\datatables\widgets;

use mimicreative\datatables\assets\DataTableAsset;
use mimicreative\datatables\columns\LinkColumn;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\AssetBundle;

/**
 * Class DataTable
 *
 * @author Haqqi <me@haqqi.net>
 * @package mimicreative\datatables\widgets
 * 
 * First version of datatable widget. Will be useful for ajax datatable.
 */
class DataTable extends Widget
{
    /**
     * @var array Html options for table
     * @see Html::renderTagAttributes() for better understanding
     */
    public $tableOptions = [];

    /**
     * @var array Options to be passed to datatables configuration, using json encode.
     * @see datatables.net
     */
    public $dataTable = [];

    public function init()
    {
        parent::init();
        
        DataTableAsset::register($this->view);

        //the table id must be set
        if (!isset($this->tableOptions['id'])) {
            $this->tableOptions['id'] = 'dt-' . $this->getId();
        }
        
        $this->initColumns();
        
        $defaultTableOptions = [
            'class' => [
                'table',
                'table-striped',
                'table-bordered',
                'table-hover'
            ]
        ];

        echo Html::beginTag('table', ArrayHelper::merge($defaultTableOptions, $this->tableOptions));
    }

    public function run()
    {
        echo Html::endTag('table');
        $this->getView()->registerJs('jQuery("#' . $this->tableOptions['id'] . '").DataTable(' . Json::encode($this->dataTable) . ');');
    }

    protected function initColumns()
    {
        $dataTable =& $this->dataTable;

        if (isset($dataTable['columns'])) {
            // adjust the variable for callable function
            if ($dataTable['columns'] instanceof \Closure) {
                $dataTable['columns'] = call_user_func($dataTable['columns']);
            }

            foreach ($dataTable['columns'] as $key => $value) {
                // if it is simple column, use the value as the data
                if (is_string($value)) {
                    $dataTable['columns'][$key] = ['data' => $value, 'title' => Inflector::camel2words($value)];
                    continue;
                }
                // if it is array,
                if (isset($value['type'])) {
                    // custom type
                    if ($value['type'] == 'link') {
                        $value['class'] = LinkColumn::className();
                        unset($value['type']);
                    }
                }

                // create column class
                if (isset($value['class'])) {
                    $column                     = \Yii::createObject($value);
                    $dataTable['columns'][$key] = $column;
                }
            }
        }
    }
}
