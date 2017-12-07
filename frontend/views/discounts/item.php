
<?php
$date = strtotime($model->date);
$month = "";

switch (date("n", $date)){
    case 1: $month = "январья";break;
    case 2: $month = "февраля";break;
    case 3: $month = "марта";break;
    case 4: $month = "апреля";break;
    case 5: $month = "мая";break;
    case 6: $month = "июня";break;
    case 7: $month = "июля";break;
    case 8: $month = "августа";break;
    case 9: $month = "сентября";break;
    case 10: $month = "октября";break;
    case 11: $month = "ноября";break;
    case 12: $month = "декабря";break;

}
?>
<a href="<?php echo $model->getUrl();?>">
<div class="block-news">
    <div class="forimg">

        <img src="<?php echo $model->image->getUrl('252x126');?>" alt="" />

    </div>
    <div class="datet"><?php echo date("d", $date);?> <?php echo $month;?>, <?php echo date("Y", $date);?></div>
    <hr/>
    <p>
        <?php echo $model->getMultiLang('title');?>
    </p>
    <a href="<?php echo $model->getUrl();?>" class="slk"><?=Yii::t('app', 'Подробнее')?></a>
</div>
</a>