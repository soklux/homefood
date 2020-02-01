<div class="control-group" id="permission_ctl">

    <!--<div class="checkbox">
        <label>
            <input id="RbacUser_reports_all" name="RbacUser_reports_all" type="checkbox" class="ace" value="1" />
            <span class="lbl" /> Select All</span>
        </label>
    </div>
    <?php /*foreach (Authitem::model()->getAuthItemData($permission) as $id=>$value): */?>
        <div class="checkbox">
            <label>
                <input name="RbacUser[reports][]" type="checkbox" class="ace" value="<?/*= $value['name'] */?>" />
                <span class="lbl" /><?/*= $value["description"] */?></span>
            </label>
        </div>
    --><?php /*endforeach */?>

    <?php echo CHtml::activeCheckboxList($user, $control_name,Authitem::model()->getAuthItemDataList($permission),
        array('separator' => '',
            'checkAll' => Yii::t('app','Select All'),
            'template' =>'<div class="checkbox"><label>{input}<span class="lbl">{label}</span></label></div>',
            'class' => 'ace'
            /*'labelOptions' => array(
                    'class' => '<div class="ace"></div>'
            )*/
        )
    );
    ?>

</div>
