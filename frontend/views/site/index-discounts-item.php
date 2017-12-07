    <div class="item">
        <div class="banner-main" style="background-image:url(<?php echo $model->image->getUrl();?>);">
            <div class="block-position">
                <div class="line-m"></div>
                <div class="tex">
                    <span><?php echo $model->getMultiLang('title');?></span><br>
                    <?php echo $model->getMultiLang('short_description');?><br>
                    <a href="<?php echo $model->getUrl();?>" class="hvr-shutter-in-horizontal">
                        <?=\Yii::t('app', 'Подробнее')?>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
