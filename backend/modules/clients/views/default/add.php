<?

$this->title='Add New Client';

    $this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="heading-buttons">
    <h3><?=$this->title?><span> | Clients</span></h3>

    <div class="clearfix"></div>
</div>

<div class="separator bottom"></div>

<div class="innerLR">

    <?=$form?>

</div>
