<?
use yii\helpers\Html;

?>

<h3 class="heading-mosaic">Устройство <?=$promo->number?></h3>

<div class="innerLR">
    <?=Html::a('Редактировать', ['/devices/default/edit','id'=>$promo->id],['class'=>'btn btn-primary'])?>
    <div style="clear:both; height: 10px;"></div>

    <!-- Widget -->
    <div class="widget">

        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">Изменения температуры</h4>
        </div>
        <!-- // Widget heading END -->

        <div class="widget-body">

            <!-- Chart with lines and fill with no points -->
            <div id="chart_lines_fill_nopoints" style=" height: 250px;"></div>
        </div>
    </div>
    <!-- // Widget END -->

    <!-- Widget -->
    <div class="widget">

        <!-- Widget heading -->
        <div class="widget-head">
            <h4 class="heading">Продажи</h4>
        </div>
        <!-- // Widget heading END -->

        <div class="widget-body">

            <!-- Chart with lines and fill with no points -->
            <div id="solds" style=" height: 250px;"></div>
        </div>
    </div>
    <!-- // Widget END -->

</div>
<div class="clear"></div>

<?
    $jsEnd="
            var chartNopointsData=[
    ";
    foreach($temperatures as $temperature){
            $jsEnd.="[".strtotime($temperature->added_date)."000, ".$temperature->temperature."],";
    }
    $jsEnd.="
            ];
    ";
    $jsEnd.="
            var chartNopointsData2=[
    ";
    foreach($solds as $sold){
            $jsEnd.="[".strtotime($sold->added_date)."000, ".$sold->sold."],";
    }
    $jsEnd.="
            ];

            $(function(){
                $.plot(
                    '#chart_lines_fill_nopoints',
                    [{
                        label: 'Температура',
                        data: chartNopointsData,
                        lines: {fillColor: '#fff8f2'},
                        points: {fillColor: '#88bbc8'}
                    }],
                    {
                        grid: {
                            show: true,
                            aboveData: true,
                            color: '#3f3f3f',
                            labelMargin: 5,
                            axisMargin: 0,
                            borderWidth: 0,
                            borderColor:null,
                            minBorderMargin: 5 ,
                            clickable: true,
                            hoverable: true,
                            autoHighlight: true,
                            mouseActiveRadius: 20,
//                            backgroundColor : {  },
                        },
                        series: {
                            grow: {active:false},
                            lines: {
                                show: true,
                                fill: true,
                                lineWidth: 2,
                                steps: false
                            },
                            points: {show:false}
                        },
                        legend: { position: 'nw' },

                        xaxis: {mode: 'time'},
                        colors: [themerPrimaryColor, '#444', '#777', '#999', '#DDD', '#EEE'],
                        shadowSize:1,
                        tooltip: true,
                        tooltipOpts: {
                            content: '%s : %y.0',
                            shifts: {
                                x: -100,
                                y: -50
                            },
                            defaultTheme: false
                        }
                    }
                );

                $.plot(
                    '#solds',
                    [{
                        label: 'Продажи',
                        data: chartNopointsData2,
                        bars: {order: 1}
//                        lines: {fillColor: '#fff8f2'},
//                        points: {fillColor: '#88bbc8'}
                    }],
                    {
                        bars: {
                            show:true,
                            barWidth: 0.2,
                            fill:1
                        },
                        grid: {
                            show: true,
                            aboveData: false,
                            color: '#3f3f3f' ,
                            labelMargin: 5,
                            axisMargin: 0,
                            borderWidth: 0,
                            borderColor:null,
                            minBorderMargin: 5 ,
                            clickable: true,
                            hoverable: true,
                            autoHighlight: false,
                            mouseActiveRadius: 20,
//                            backgroundColor : { }
                        },
                        series: {
                            grow: {active:false}
                        },
                        legend: { position: 'ne' },
                        colors: [themerPrimaryColor, '#444', '#777', '#999', '#DDD', '#EEE'],
                        xaxis: {mode: 'time'},
                        tooltip: true,
                        tooltipOpts: {
                            content: '%s : %y.0',
                            shifts: {
                                x: -100,
                                y: -50
                            },
                            defaultTheme: false
			            }
                    }
                );
            });
    ";
    $this->registerJs($jsEnd, \yii\web\View::POS_END);

?>




