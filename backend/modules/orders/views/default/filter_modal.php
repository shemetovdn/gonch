<div class="modal fade modal-size-small" id="add_param_<?=$filter->id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Добавить новое значение для "<?=$filter->title;?>"</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <input type="text" class="form-control" name="ParametrsValue[title]" placeholder="Введите значение (рус.)..."><br />
                        <input type="text" class="form-control" name="ParametrsValue[title_ua]" placeholder="Введите значение (укр.)..."><br />
                        <input type="text" class="form-control" name="ParametrsValue[title_en]" placeholder="Введите значение (англ.)...">
                        <input type="hidden" name="ParametrsValue[parametr_id]" value="<?=$filter->id;?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary addButton">Добавить</button>
            </div>
        </div>
    </div>
</div>
