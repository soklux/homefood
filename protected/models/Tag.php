<?php

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property integer $id
 * @property string $name
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Tag extends CActiveRecord
{
    public $search;
    public $brand_archived;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tag_name', 'length', 'max' => 50),
            
            // array('status', 'length', 'max'=>1),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tag_name, search', 'safe', 'on' => 'search'),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag_name' => Yii::t('app','Name'), //'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		$criteria->compare('tag_name',$this->tag_name,true);

        // if  ( Yii::app()->user->getState('brand_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
        //     $criteria->condition = 'name like :search';
        //     $criteria->params = array(
        //         ':search' => '%' . $this->search . '%',
        //     );
        // } else {
        //     $criteria->condition = 'status=:active_status AND (name like :search)';
        //     $criteria->params = array(
        //         ':active_status' => Yii::app()->params['active_status'],
        //         ':search' => '%' . $this->search . '%',
        //     );
        // }
        $criteria->condition = 'tag_name like :search';
        $criteria->params = array(
            ':search' => '%' . $this->search . '%',
        );
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('tag_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'tag_name')
        ));

	}

    protected function getTagInfo()
    {
        return $this->tag_name;

    }

    public function getTag()
    {
        $model = Tag::model()->findAll();
        $list = CHtml::listData($model, 'id', 'TagInfo');
        return $list;
    }

    public function getTagByItemId($id){
        $sql = "SELECT tag_name
                FROM tag t JOIN product_tag pt
                ON t.id=pt.tag_id JOIN item i
                ON pt.product_id=i.id
                WHERE i.id=:id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':id' => $id
            )
        );

        return $result;
    }
    public function deleteTagByItemId($id){
                $sql="DELETE t,pt
                FROM tag t JOIN product_tag pt
                ON t.id=pt.tag_id JOIN item i
                ON pt.product_id=i.id
                WHERE i.id=:id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                ':id' => $id
            )
        );

        return $result;
    }
    public function saveTag($name)
    {

        $tag_id = null;
        // $exists = Tag::model()->exists('tag_name=:name', array(':name' => $name));
        //if (!$exists) {
            $tag = new Tag;
            $tag->tag_name = $name;
            $tag->save();
            $tag_id = $tag->id;
        // }

        return $tag_id;
    }
    // public function deleteBrand($id)
    // {
    //     Brand::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    // }

    // public function restoreBrand($id)
    // {
    //     Brand::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    // }

    // public static function getBrandColumn()
    // {
    //     return
    //         array(
    //             array(
    //                 'name' => 'name',
    //                 'value' => '$data->status=="1" ? $data->name : "<s class=\"red\">  $data->name <s>" ',
    //                 'type' => 'raw',
    //             ),
    //             'modified_date',
    //             array(
    //                 'class' => 'bootstrap.widgets.TbButtonColumn',
    //                 'header' => Yii::t('app', 'Action'),
    //                 'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
    //                 'buttons' => array(
    //                     'update' => array(
    //                         //updateDialogOpen
    //                         'click' => '',
    //                         'url' => 'Yii::app()->createUrl("category/update2", array("id"=>$data->id))',
    //                         'label' => 'Update Category',
    //                         'icon' => 'ace-icon fa fa-edit',
    //                         'options' => array(
    //                             'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
    //                             'data-refresh-grid-id' => 'category-grid',
    //                             'class' => 'btn btn-xs btn-info',
    //                         ),
    //                         'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("category.update2")',
    //                     ),
    //                     'delete' => array(
    //                         'label' => Yii::t('app', 'Delete Category'),
    //                         'options' => array(
    //                             'data-update-dialog-title' => Yii::t('app', 'Delete Category'),
    //                             'titile' => 'Delete Category',
    //                             'class' => 'btn btn-xs btn-danger',
    //                         ),
    //                         'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("category.delete")',
    //                     ),
    //                     'restore' => array(
    //                         'label' => Yii::t('app', 'Restore Category'),
    //                         'url' => 'Yii::app()->createUrl("category/restore", array("id"=>$data->id))',
    //                         'icon' => 'bigger-120 glyphicon-refresh',
    //                         'options' => array(
    //                             'class' => 'btn btn-xs btn-warning btn-undodelete',
    //                         ),
    //                         'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("category.delete")',
    //                     ),
    //                 ),
    //             ),
    //         );
    // }
}