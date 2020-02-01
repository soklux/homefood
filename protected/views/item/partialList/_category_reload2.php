<?php

	$arr = Category::model()->buildTree($model);

?>
    <option value="">--Choose Parent--</option>
        <?= Category::model()->buildOptions($arr,$cid) ?>
    <optgroup >
        <option value="addnew">
            Create New
        </option>
    </optgroup>