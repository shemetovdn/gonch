<?

    $this->title='Add New Item';

    $this->params['breadcrumbs'][] = ['label' => $this->context->title, 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="heading-buttons">
    <h3><?=$this->title?><span></span></h3>

    <div class="clearfix"></div>
</div>

<div class="separator bottom"></div>

<div class="innerLR">

    <?=$form?>

</div>
