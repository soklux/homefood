<?php

/**
 * This is the model class for table "price_tier".
 *
 * The followings are the available columns in table 'price_tier':
 * @property integer $id
 * @property string $tier_name
 * @property string $modified_date
 * @property string $status
 */
class PriceTier extends CActiveRecord
{
    public $pricetier_archived;
    public $search;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'price_tier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tier_name', 'required'),
            array('tier_name', 'unique'),
            array('tier_name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 1),
            array('modified_date', 'safe'),
            // @todo Please remove those attributes that should not be searched.
            array('tier_name, status, search', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'tier_name' => Yii::t('app','Name'),
            'modified_date' => Yii::t('app','Modified Date'),
            'status' => Yii::t('app','Status'),
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        //$criteria->compare('id',$this->id);
        //$criteria->compare('tier_name', $this->tier_name, true);
        //$criteria->compare('deleted',$this->deleted);

        if ( Yii::app()->user->getState('pricetier_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'tier_name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (tier_name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pricetier_pageSize', Yii::app()->params['defaultPageSize']),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PriceTier the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function deletePriceTier($id)
    {
        PriceTier::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restorePriceTier($id)
    {
        PriceTier::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    protected function getPriceTierInfo()
    {
        return $this->tier_name;
    }

    public function getPriceTier()
    {
        $model = PriceTier::model()->findAll(array(
            'order' => 'id',
            'condition' => 'status=:active_status',
            'params' => array(':active_status' => Yii::app()->params['active_status'])
        ));
        $list = CHtml::listData($model, 'id', 'PriceTierInfo');

        return $list;
    }

    public function getListPriceTier()
    {
        $sql = "SELECT id tier_id,tier_name,null price FROM `price_tier` WHERE status=:active_status ORDER BY id";
        $result = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':active_status' => Yii::app()->params['active_status'] ));

        return $result;
    }

    public function getListPriceTierUpdate($item_id)
    {
        $sql = "SELECT pt.id tier_id,pt.tier_name,price
                  FROM price_tier pt LEFT JOIN item_price_tier ipt ON ipt.`price_tier_id`=pt.id 
                            AND ipt.`item_id`=:item_id
                  WHERE pt.status=:active_status
                  ORDER BY pt.id";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':item_id' => $item_id, ':active_status' => Yii::app()->params['active_status']));

        return $result;
    }

    public function checkExists()
    {
        return PriceTier::model()->count('status=:active_status',
            array(':active_status' => Yii::app()->params['active_status']));
    }

    public static function getPriceTierColumn()
    {
        return
            array(
                array(
                    'name' => 'tier_name',
                    'value' => '$data->status=="1" ? $data->tier_name : "<s class=\"red\">  $data->tier_name <s>" ',
                    'type' => 'raw',
                ),
                'modified_date',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            'click' => 'updateDialogOpen',
                            'label' => 'Update Price Tier',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
                                'data-refresh-grid-id' => 'price-tier-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.update")',
                        ),
                        'delete' => array(
                            'label' => Yii::t('app', 'Delete Price Tier'),
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Delete Price Tier'),
                                'titile' => 'Edit Item',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.delete")',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore Price Tier'),
                            'url' => 'Yii::app()->createUrl("pricetier/restore", array("id"=>$data->id))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("item.delete")',
                        ),
                    ),
                ),
            );
    }
}
