
<div class="col-xs-12 widget-container-col" id="widget-container-col-2">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'role-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'validateOnType'=>true,
        ),
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>


    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?= $form->textFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>45)); ?>

    <?= $form->textAreaControlGroup($model, 'description', array('rows' => 2, 'cols' => 10, 'class' => 'span3')); ?>

    <p></p>

    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

    <div class="widget-box widget-color-blue" id="widget-box-2">
        <!-- #section:custom/widget-box.options -->
        <div class="widget-header">
            <h5 class="widget-title bigger lighter">
                <i class="ace-icon fa fa-table"></i>
                Tables & Colors
            </h5>

            <div class="widget-toolbar widget-toolbar-light no-border">
                <select id="simple-colorpicker-1" class="hide">
                    <option selected="" data-class="blue" value="#307ECC">#307ECC</option>
                    <option data-class="blue2" value="#5090C1">#5090C1</option>
                    <option data-class="blue3" value="#6379AA">#6379AA</option>
                    <option data-class="green" value="#82AF6F">#82AF6F</option>
                    <option data-class="green2" value="#2E8965">#2E8965</option>
                    <option data-class="green3" value="#5FBC47">#5FBC47</option>
                    <option data-class="red" value="#E2755F">#E2755F</option>
                    <option data-class="red2" value="#E04141">#E04141</option>
                    <option data-class="red3" value="#D15B47">#D15B47</option>
                    <option data-class="orange" value="#FFC657">#FFC657</option>
                    <option data-class="purple" value="#7E6EB0">#7E6EB0</option>
                    <option data-class="pink" value="#CE6F9E">#CE6F9E</option>
                    <option data-class="dark" value="#404040">#404040</option>
                    <option data-class="grey" value="#848484">#848484</option>
                    <option data-class="default" value="#EEE">#EEE</option>
                </select>
            </div>
        </div>

        <!-- /section:custom/widget-box.options -->
        <div class="widget-body">
            <div class="widget-main no-padding">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr>
                        <th>
                            <i class="ace-icon fa fa-user"></i>
                            User
                        </th>

                        <th>
                            <i>@</i>
                            Email
                        </th>
                        <th class="hidden-480">Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td class="">Alex</td>

                        <td>
                            <a href="#">alex@email.com</a>
                        </td>

                        <td class="hidden-480">
                            <span class="label label-warning">Pending</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="">Fred</td>

                        <td>
                            <a href="#">fred@email.com</a>
                        </td>

                        <td class="hidden-480">
                            <span class="label label-success arrowed-in arrowed-in-right">Approved</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="">Jack</td>

                        <td>
                            <a href="#">jack@email.com</a>
                        </td>

                        <td class="hidden-480">
                            <span class="label label-warning">Pending</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="">John</td>

                        <td>
                            <a href="#">john@email.com</a>
                        </td>

                        <td class="hidden-480">
                            <span class="label label-inverse arrowed">Blocked</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="">James</td>

                        <td>
                            <a href="#">james@email.com</a>
                        </td>

                        <td class="hidden-480">
                            <span class="label label-info arrowed-in arrowed-in-right">Online</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.span -->