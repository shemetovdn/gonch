<?php

namespace wbp\widgets;

use backend\modules\stores\models\Stores;
use yii\base\Widget;
use yii\helpers\Html;
use yii\jui\JuiAsset;
use yii\web\View;


class PricesWidget extends Widget {

    public $formModel,$attribute,$itemTemplate;
    protected $id;
    /**
     * Initializes the widget.
     */
    public function init() {
        $this->id=uniqid('pricesWidget_');

        $this->itemTemplate= <<<EOF
            <div class="item">
                <div class="col-md-5">
                    %input1%
                </div>
                <div class="col-md-2">
                    %input2%
                </div>
                <div class="col-md-2">
                    %input3%
                </div>
                <div class="col-md-1">
                    <span class="btn btn-block btn-danger btn-icon btn-only-icon removeButton glyphicons remove_2"><i></i>&nbsp;</span>
                </div>
                <div style="clear:both; height:7px;"></div>
            </div>
EOF;

        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run() {
        $this->registerScripts();
        echo $this->renderWidget();
    }

    /**
     * render file input tag
     * @return string
     */
    private function renderWidget() {
        $items="";

        foreach((array)$this->formModel->{$this->attribute} as $num=>$prop) {
            $inputTemplate1 = Html::activeTextInput($this->formModel, $this->attribute.'['.$num.'][value]', ['class' => 'form-control','value'=>$prop['value'],'placeholder'=>'Enter price here...']);
            $inputTemplate1 .= Html::activeHiddenInput($this->formModel, $this->attribute.'['.$num.'][id]', ['class' => 'form-control','value'=>$prop['id']]);
            $inputTemplate2 = Html::activeTextInput($this->formModel, $this->attribute.'['.$num.'][qty_start]', ['class' => 'form-control','value'=>$prop['qty_start'],'placeholder'=>'Start QTY']);
            $inputTemplate3 = Html::activeTextInput($this->formModel, $this->attribute.'['.$num.'][qty_end]', ['class' => 'form-control','value'=>$prop['qty_end'],'placeholder'=>'End QTY']);
            $items .= str_replace(array("\n","%input1%","%input2%","%input3%"),array("",$inputTemplate1,$inputTemplate2,$inputTemplate3),$this->itemTemplate);
        }

        $result = <<<EOF
            <div id="{$this->id}">
                <div class="row">
                    <div class="sortable">
                        {$items}
                    </div>
                </div>
                <div class="separator bottom"></div>

                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <span class="btn btn-block btn-warning addOneButton">Add one</span>
                    </div>
                </div>
            </div>
EOF;

        return $result;
    }

    /**
     * register script
     */
    private function registerScripts() {
        $num=count($this->formModel->{$this->attribute});
        $inputTemplate1 = Html::activeTextInput($this->formModel,$this->attribute.'[%num%][value]',['class'=>'form-control','placeholder'=>'Enter price here...']);
        $inputTemplate1 .= Html::activeHiddenInput($this->formModel, $this->attribute.'[%num%][id]', ['class' => 'form-control']);
        $inputTemplate2 = Html::activeTextInput($this->formModel,$this->attribute.'[%num%][qty_start]',['class'=>'form-control','placeholder'=>'Start QTY']);
        $inputTemplate3 = Html::activeTextInput($this->formModel,$this->attribute.'[%num%][qty_end]',['class'=>'form-control','placeholder'=>'End QTY']);
        $itemTemplate = str_replace(array("\n","\r\n","\r","%input1%","%input2%","%input3%"),array("","","",$inputTemplate1,$inputTemplate2,$inputTemplate3),$this->itemTemplate);
        $itemTemplate = str_replace(array("\n","\r\n","\r"),array("","",""),$itemTemplate);

        JuiAsset::register($this->view);

        $script = <<<EOF
            var num_{$this->id}={$num};
            123;
            $('#{$this->id} .addOneButton').click(function(){
                $('#{$this->id} .sortable').append(('{$itemTemplate}').replace(/%num%/g,num_{$this->id}));
                num_{$this->id}++;
            });

            $(document).on("click","#{$this->id} .removeButton",function(){
                var item=$(this).parents('.item');
                bootbox.confirm("Are you sure want to delete this item?", function(result){
                    if(result===true){
                        item.remove();
                    }
                });
            });

            $( "#{$this->id} .sortable" ).sortable({
              handle: ".sortHandle"
            });
EOF;
        $this->view->registerJs($script, View::POS_READY);
    }

}
