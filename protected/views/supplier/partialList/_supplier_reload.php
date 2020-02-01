<?php foreach($model as $key=>$value):?>
    <?php if($id==$value['id']):?>
        <option value="<?=$value['id']?>" selected><?=$value['company_name']?></option>
    <?php else:?>
        <option value="<?=$value['id']?>"><?=$value['company_name']?></option>    
    <?php endif;?>
<?php endforeach;?>
    <optgroup >
        <option value="addnew">
            Create New
        </option>
    </optgroup>