<div class="widget-body">
    <div class="widget-main no-padding">

            <?php /*$this->renderPartial('//role/control/_grid_header') */?>

            <?php foreach ($grid_items  as $key => $value): ?>
                <?php $this->renderPartial('//role/control/_grid_body', array(
                    'user' => $user,
                    'grid_title' => $value['grid_title'],
                    'permission' => $value['permission'],
                    'control_name' => $value['control_name'],
                )) ?>
            <?php endforeach; ?>

            <!--<div class="control-group">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <input name="form-field-checkbox" type="checkbox" class="ace" />
                        <span class="lbl"><?/*= 'Report' */?></span>
                    </h5>
                </div>
                <div class="checkbox">
                    <label>
                        <input name="form-field-checkbox" type="checkbox" class="ace" />
                        <span class="lbl"> choice 1</span>
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input name="form-field-checkbox" type="checkbox" class="ace" />
                        <span class="lbl"> choice 2</span>
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox" />
                        <span class="lbl"> choice 3</span>
                    </label>
                </div>

                <div class="checkbox">
                    <label class="block">
                        <input name="form-field-checkbox" disabled="" type="checkbox" class="ace" />
                        <span class="lbl"> disabled</span>
                    </label>
                </div>

            </div>-->

    </div>
</div>