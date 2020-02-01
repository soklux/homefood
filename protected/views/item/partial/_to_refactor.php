<?php

$model = Category::model()->findAll();

$arr = Category::model()->buildTree($model);

//print_r($arr);

print_r(Category::model()->buildOptions($arr,null));
