
<input type="hidden" value="<?=$category_id?>" id="pid<?=($i-1)?>"> 
        <div class="col-sm-11 col-md-11">
            <hr>
            <h3 id="success">Data Successfully saved.</h3>
                <div class="form-group">
                    <?php echo CHtml::label('Category Name', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('Category',$category_name,array('class'=>'form-control txt-box','id'=>'Category_Name'));?>
                    <span id="error" class="errorMsg<?=($i-1)?>"></span>
            </div>
        </div>
        <div class="col-sm-11 col-md-11">
            <div class="form-group">
                <?php $arr = Category::model()->buildTree($model);?>
                <?php echo CHtml::label('Parent', 1, array('class' => 'control-label'));?>
                <select class="form-control" id="db-category<?=($i-1)?>" onchange="showDialog(event.target.value)">
                    <option value="">--Choose Parent--</option>
                    <?=Category::model()->buildOptions($arr,$parent_id)?>
                    <optgroup >
                        <option value="addnew">
                            Create New
                        </option>
                    </optgroup>
                </select>
            </div>
        </div>