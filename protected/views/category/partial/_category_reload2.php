<?php

$arr = Category::model()->buildTree($model);

//print_r($arr);
// print_r(Category::model()->buildOptions($arr,null));
?>
    <option value=""></option>
        <?= Category::model()->buildOptions($arr,$cid) ?>
    <optgroup >
        <option value="addnew">
            Create New
        </option>
    </optgroup>