<div class="widget-body">
    <div class="widget-main no-padding">

        <table class="table table-striped table-bordered table-hover role-table">

            <?php $this->renderPartial('//role/grid/_grid_header') ?>

            <?php foreach ($grid_items  as $key => $value): ?>
                <?php $this->renderPartial('//role/grid/_grid_body', array(
                    'user' => $user,
                    'grid_title' => $value['grid_title'],
                    'permission' => $value['permission'],
                    'control_name' => $value['control_name'],
                    'auth_items' => $auth_items,
                )) ?>
            <?php endforeach; ?>

            <!--<tbody>
                    <td> <?/*= Yii::t('app','Item'); */?> </td>
                    <td class="permission">
                        <input value="All" type="checkbox" name="Authitem_name_all">
                    </td>
                    <?php /*foreach (Authitem::model()->getAuthItemData('item') as $id => $item): */?>
                        <td class="permission">
                            <input value="<?/*= $item["name"]; */?>" type="checkbox" name="Authitem_name_all">
                        </td>
                    <?php /*endforeach; */?>

                    <?php /*$this->renderPartial('//role/_grid_more'); */?>
                </tbody>-->

        </table>

    </div>
</div>