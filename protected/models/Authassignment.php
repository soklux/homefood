<?php

/**
 * This is the model class for table "authassignment".
 *
 * The followings are the available columns in table 'authassignment':
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Authitem $itemname0
 */
class Authassignment extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'AuthAssignment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('itemname, userid', 'required'),
            array('itemname, userid', 'length', 'max' => 64),
            array('bizrule, data', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('itemname, userid, bizrule, data', 'safe', 'on' => 'search'),
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
            'itemname' => array(self::BELONGS_TO, 'Authitem', 'itemname'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'itemname' => 'Itemname',
            'userid' => 'Userid',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('itemname', $this->itemname, true);
        $criteria->compare('userid', $this->userid, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Authassignment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function deleteAuthassignment($user_id)
    {
        $sql = "DELETE FROM AuthAssignment WHERE userid=:user_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $command->execute();
    }

    public function rolePermission($name)
    {
       $sql = "select t1.name,t2.child,
                  (select ts.description from AuthItem ts where ts.name = t2.child) description
                from AuthItem t1 join AuthItemChild t2
                 on t2.parent=t1.name
                where t1.name=:name and
                t1.type='2'
                order by t2.child";

        $rawData = Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));

        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'name',
            'pagination' => false,
        ));

        return $dataProvider;
    }
}
