<?
$items['one'] = 'Request';
$items['remove'] = 'Remove';

$this->title = 'Edit item';

$this->params['breadcrumbs'][] = ['label' => $this->context->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="heading-buttons">
    <h3><?= $items['one'] ?> #<?= $model->id ?> "<?= $model->email ?>"<span> | <?= $this->controller->title ?></span></h3>

    <div class="buttons pull-right">

    </div>

    <div class="clearfix"></div>
</div>

<div class="separator bottom"></div>

<div class="innerLR">

    <?=$form?>

</div>
