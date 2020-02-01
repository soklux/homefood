<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Category extends CActiveRecord
{
    public $search;
    public $category_archived;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            //array('name', 'unique'),
            array('name', 'length', 'max' => 50),
            array('created_date, modified_date', 'safe'),
            array('created_date', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => true, 'on' => 'insert'),
            array(
                'created_date,modified_date',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => 'update'
            ),
            array('status', 'length', 'max'=>1),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, search', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'items' => array(self::HAS_MANY, 'Item', 'category_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('app','Name'), //'Name',
            'parent_id' => Yii::t('app','Parent'), //'Name',
            'created_date' => Yii::t('app','Created Date'), //'Created Date',
            'modified_date' => Yii::t('app','Modified Date'), //'Modified Date',
        );
    }

    public function search()
    {

        $criteria=new CDbCriteria;
        //$arr = $this->buildTree(Category::model()->findAll());
        //$criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);

        if  ( Yii::app()->user->getState('category_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('category_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'name')
        ));

    }

    public function search2($search)
    {

        $criteria=new CDbCriteria;
        
        // $dataP=new CArrayDataProvider ("grid");
        // $dataP->setData($data);

        $criteria->compare('name',$this->name,true);

        if  ( Yii::app()->user->getState('category_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'name like :search';
            $criteria->params = array(
                ':search' => '%' . $search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $search . '%',
            );
        }
        $cate_array=explode(',', Category::model()->buildCategoryView(Category::model()->buildTree(Category::model()->findAll($criteria)),null));
        $data=array();
        // $cate_array=array_search('Drink', $cate_array);
        foreach($cate_array as $v){
            $category=explode('|', $v);

            if($category[0]!='' ){
                $data[]=array('id'=>$category[1],'status'=>$category[0],'modified_date'=>$category[2],'name'=>$category[3]);
            }

        }
        // $data=array_filter(
        //     $data,
        //     function ($search){
        //         return ($search & 1);
        //     }
        // );
        return new CArrayDataProvider($data, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('category_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'name')
        ));

    } 
    protected function getCategoryInfo()
    {
        return $this->name;

    }

    public function getCategory()
    {
        $model = Category::model()->findAll();
        $list = CHtml::listData($model, 'id', 'CategoryInfo');
        return $list;
    }

    // Get Item Category for select 2 -- cannot finding the style of normal select and button next to it
    public static function getCategory2($name = '')
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = "SELECT id ,name AS text 
                FROM category 
                WHERE (name LIKE :name)";

        $name = '%' . $name . '%';
        return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));

    }

    public function saveCategory($category_name)
    {
        $category_id = null;
        //$exists = Category::model()->exists('CONVERT(id,CHAR(3))=:category_id', array(':category_id' => $category_name));
        //if (!$exists) {
        $category = new Category;
        $category->name = $category_name;
        $category->save();
        $category_id = $category->id;
        //}

        return $category_id;
    }

    public function deleteCategory($id)
    {
        Category::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restoreCategory($id)
    {
        Category::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    public static function getCategoryColumn()
    {
        return
            array(
                array(
                    'name' => 'name',
                    'value' => '$data["status"]=="1" ? $data["name"] : $data["name"] ',
                    // 'value' => '$data["name"] .  Category::model()->showSubCategories($data["id"]," / ")',
                    //'value' => 'Category::model()->buildTree(Category::model()->findAll(), $data->parent_id)',
                    'type' => 'raw',
                ),
                'modified_date',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            'click' => '',
                            'url' => 'Yii::app()->createUrl("category/update2", array("id"=>$data["id"]))',
                            'label' => 'Update Category',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
                                'data-refresh-grid-id' => 'category-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("category.update")',
                        ),
                        'delete' => array(
                            'url' => 'Yii::app()->createUrl("category/delete/",array("id"=>$data["id"]))', 
                            'label' => Yii::t('app', 'Delete Category'),
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Delete Category'),
                                'titile' => 'Delete Category',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("category.delete")',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore Category'),
                            'url' => 'Yii::app()->createUrl("category/restore", array("id"=>$data["id"]))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data["status"]=="0" && Yii::app()->user->checkAccess("category.delete")',
                        ),
                    ),
                ),
            );
    }

    public function buildTreeView( $ar, $pid = null ) {
         $op = array();
        foreach( $ar as $item ) {
            if( $item['parent_id'] == $pid ) {
                $op[$item['name']] = array(
                    'text' => '<span style="display:inline-block;width:50%;" onclick="loadProduct('.$item['id'].',\'\')">'.$item['name'].'</span>',
                    'icon-class'=>'orange',
                    'type'=>'folder',
                    //'parent_id' => $item['parent_id']
                );
                // using recursion
                $children =  $this->buildTreeView( $ar, $item['id'] );
                if( $children) {
                    $children['text']=$item['name'];
                    $children['type']='item';
                    $children['icon-class']='pink';
                    $op[$item['name']]['additionalParameters']['children'] = $children;
                }else{
                    $op[$item['name']] = array(
                        'text' => '<span style="display:inline-block;width:50%;" onclick="loadProduct('.$item['id'].',\'\')">'.$item['name'].'</span>',
                        'icon-class'=>'orange',
                        'type'=>'item',
                    );
                }
            }else{

            }
        }
        return $op;
    }
    
    public function buildTree( $ar, $pid = null ) {
        $op = array();
        if(!empty($ar)){
            foreach( $ar as $item ) {
                if( $item['parent_id'] == $pid ) {
                    $op[$item['id']] = array(
                        'name' => $item['name'],
                        'parent_id' => $item['parent_id'],
                        'id'=> $item['id'],
                        'status'=> $item['status'],
                        'modified_date'=> $item['modified_date']
                    );
                    // using recursion
                    $children =  $this->buildTree( $ar, $item['id'] );
                    if( $children ) {
                        $op[$item['id']]['children'] = $children;
                    }
                }
            }
        }
        
        return $op;
    }


    public function buildOptions($arr, $target, $parent = NULL) {
        $html = "";
        foreach ( $arr as $key => $v )
        {
            if ( $key == $target )
                $html .= "<option value='$key' selected>$parent {$v['name']}</option>";
            else
                $html .= "<option value=\"$key\">$parent {$v['name']}</option>";

            if (array_key_exists('children', $v))
                $html .= $this->buildOptions($v['children'],$target,$parent . $v['name']." / ");
        }

        return $html;
    }

    public function buildCategoryView($arr, $target, $parent = NULL) {
        $html = "";
        foreach ( $arr as $key => $v )
        {
            // $html.="|";
            if ( $key == $target ){
                 $html.= "$parent {$v['name']},";
            }
            else{
                 $html.= "{$v['status']}|{$v['id']}|{$v['modified_date']}|$parent {$v['name']},";
            }

            if (array_key_exists('children', $v)){
                $html.= $this->buildCategoryView($v['children'],$target,$parent . $v['name']." / ");
            }
            
        }
        return $html;
    }

    public function buildCategoryBreadcrumb($arr, $target, $parent = NULL,$id) {
        $html = "";
        foreach ( $arr as $key => $v )
        {
            if ( $key == $target)
                $html .= "<span class='cate-hover' onclick='loadProduct({$v['parent_id']})'>$parent</span><span class='cate-hover' onclick='loadProduct(".$id.")'> {$v['name']}</span>";
            else
                $html .= "<span class='cate-hover' onclick='loadProduct({$v['parent_id']})'>$parent</span><span class='cate-hover' onclick='loadProduct(".$id.")'> {$v['name']}</span>";

            if (array_key_exists('children', $v))
                $html .=$this->buildCategoryBreadcrumb($v['children'],$target,$parent . $v['name']." / ",$id);
        }

        return $html;
    }

    public function buildTree2( $ar, $pid = null ) {
        $op = array();

        foreach( $ar as $item ) {
            if( $item['id'] == $pid) {
                $op[$item['id']] = array(
                    'name' => $item['name'],
                    'parent_id' => $item['parent_id']
                );
                // using recursion
                $children =  $this->buildTree2( $ar, $item['parent_id'] );
                if( $children ) {
                    $op[$item['id']]['children'] = $children;
                }
            }
        }
        return $op;
    }

    public function getCategoryById($category_id)
    {
        $sql = "SELECT pc.`name`,pc.id parent_id,c.id
                FROM `category` pc JOIN category c
                ON pc.id=c.parent_id
                WHERE (c.id=:category_id )";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':category_id' => (int)$category_id));
        if(!empty($result)){
            foreach($result as $value){
                return $value;
            }
        }
    }

    public function showSubCategories($cat_id, $dashes = ''){

        $rsSub = Category::model()->findAll('parent_id =:parent_id', array(':parent_id' => $cat_id));

        if (isset($rsSub)) {
            foreach (array_reverse($rsSub,true) as $key => $value) {
                echo $value['name'] . $dashes;
                $this->showSubCategories($value['id'], $dashes);
            }
        }
    }
}