<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property date $dob
 * @property string $mobile_no
 * @property string $adddress1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 * @property string $status
 *
 * The followings are the available model relations:
 * @property RbacUser[] $rbacUsers
 * @property Transactions[] $transactions
 */
class Employee extends CActiveRecord
{
    public $login_id;
    public $image;
    public $search;
    public $day; //Day : DD
    public $month; // Month : MM
    public $year; // Year - YYYY
    public $employee_archived;

	public function tableName()
	{
		return 'employee';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name', 'required'),
			array('city_id, report_to,district_id,commune_id, village_id', 'numerical', 'integerOnly' => true),
			array('first_name, last_name', 'length', 'max'=>50),
			array('mobile_no', 'length', 'max'=>15),
			array('address1, address2', 'length', 'max'=>60),
			array('country_code', 'length', 'max'=>2),
			array('email', 'length', 'max'=>30),
			array('status', 'length', 'max'=>1),
            array('dob ', 'date', 'format'=>array('yyyy-MM-dd'), 'allowEmpty'=>true),
			array('notes, dob, day, month, year', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('first_name, last_name, dob, mobile_no, adddress1, address2, city_id, country_code, email, notes, search', 'safe', 'on'=>'search'),
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
			'rbacUsers' => array(self::HAS_MANY, 'RbacUser', 'employee_id'),
			'transactions' => array(self::HAS_MANY, 'Transactions', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => Yii::t('app', 'Given Name'), //'First Name',
            'last_name' => Yii::t('app', 'Family Name'), //'Last Name',
            'mobile_no' => Yii::t('app', 'Mobile No'), //'Mobile No',
            'address1' => Yii::t('app', 'Address1'), //'Adddress1',
            'address2' => Yii::t('app', 'Address2'), //Address2',
            'city_id' => Yii::t('app', 'City'), //'City',
            'district_id' => Yii::t('app', 'District'),
            'commune_id' => Yii::t('app', 'Commune'),
            'village_id' => Yii::t('app', 'Village'),
            //'outlet_id' => Yii::t('app', 'Outlet'),
            'country_code' => Yii::t('app', 'Country Code'), //'Country Code',
            'email' => Yii::t('app', 'Email'), //'Email',
            'notes' => Yii::t('app', 'Notes'), //'Notes',
            'search' => Yii::t('app', 'Search') . Yii::t('app', 'Employee'),
            'dob' => Yii::t('app','Date of Birth'),
        );
    }

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('first_name',$this->first_name,true);
		//$criteria->compare('last_name',$this->last_name,true);
		//$criteria->compare('mobile_no',$this->mobile_no,true);
		//$criteria->compare('adddress1',$this->adddress1,true);
		//$criteria->compare('address2',$this->address2,true);
		//$criteria->compare('city_id',$this->city_id);
		//$criteria->compare('country_code',$this->country_code,true);
		//$criteria->compare('email',$this->email,true);
		//$criteria->compare('notes',$this->notes,true);
		//$criteria->compare('status',$this->status,true);

       /* if ($this->search) {
            $criteria->condition = "(first_name=:search or last_name=:search or concat(first_name,last_name)=:fullname or concat(last_name,first_name)=:fullname  or mobile_no like :mobile_no)";
            $criteria->params = array(
                ':search' => $this->search,
                ':fullname' => preg_replace('/\s+/', '', $this->search),
                ':mobile_no' => '%' . $this->search . '%',
            );
        } elseif (!Yii::app()->user->isAdmin) {
            $criteria->condition = "id not in (1,2)";
        }*/

        if ( Yii::app()->user->getState('employee_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'first_name like :search OR last_name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (first_name like :search OR last_name like :search or mobile_no like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }
        $sort = new CSort();
        $sort->defaultOrder=array('last_name' => CSort::SORT_ASC);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>$sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('employee_page_size', Common::defaultPageSize()),
            ),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function deleteEmployee($id)
    {
        Employee::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status']));
        $user = RbacUser::model()->find('employee_id=:employee_id' , array(':employee_id' => $id));
        $user->status = Yii::app()->params['inactive_status'];
        $user->save();
    }

    public function undodeleteEmployee($id)
    {
        Employee::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status']));
        $user = RbacUser::model()->find('employee_id=:employee_id' , array(':employee_id' => $id));
        $user->status = Yii::app()->params['active_status'];
        $user->save();
    }

    protected function getEmployeeInfo()
    {
        return $this->first_name . ' ' . $this->last_name;

    }

    public function getEmployee()
    {
        $model = Employee::model()->findAll('status = :status',array(':status' => param('active_status')));
        $list  = CHtml::listData($model , 'id', 'EmployeeInfo');
        return $list;
    }

    public function getEmpRep($employee_id)
    {
        $model = Employee::model()->findAll(
            array('select' => '*',
                'condition' => 'id not in ("1","2") and id<>:employee_id and status=:status',
                 'params'=>array(':employee_id' => $employee_id,':status' => param('active_status'))
                ,
            ));
        $list  = CHtml::listData($model , 'id', 'EmployeeInfo');
        return $list;
    }

    protected function afterFind()
    {
        $dob = strtotime($this->dob);

        $this->day = date('d',$dob);
        $this->month = date('m',$dob);
        $this->year = date('Y',$dob);
        return parent::afterFind();
    }

    public static function employeeByID($id)
    {
        $model = Employee::model()->findByPk($id);

        return isset($model) ? $model : null;
    }

    public static function itemAlias($type, $code = null)
    {

        $_items = array(
            'day' => array(
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                '09' => '09',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17' => '17',
                '18' => '18',
                '19' => '19',
                '20' => '20',
                '21' => '21',
                '22' => '22',
                '23' => '23',
                '24' => '24',
                '25' => '25',
                '26' => '26',
                '27' => '27',
                '28' => '28',
                '29' => '29',
                '30' => '30',
                '31' => '31',
            ),
            'month' => array(
                '01' => Yii::t('app','January'),
                '02' => Yii::t('app','February'),
                '03' => Yii::t('app','March'),
                '04' => Yii::t('app','April'),
                '05' => Yii::t('app','May'),
                '06' => Yii::t('app','June'),
                '07' => Yii::t('app','July'),
                '08' => Yii::t('app','August'),
                '09' => Yii::t('app','September'),
                '10' => Yii::t('app','October'),
                '11' => Yii::t('app','November'),
                '12' => Yii::t('app','December'),
            ),
            'year' => array_combine(range(date("Y"), 1910), range(date("Y"), 1910)),  //http://stackoverflow.com/questions/2807394/php-years-array
        );

        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else {
            return isset($_items[$type]) ? $_items[$type] : false;
        }
    }

    public function getEmployeeColumn()
    {
        return array(
            array(
                'name' => 'login_id',
                'header' => 'Login ID',
                'value' => array($this, "gridLoginIDColumn"),
            ),
            'last_name',
            'first_name',
            array(
                'name' => 'mobile_no',
            ),
            array(
                'name' => 'adddress1',
            ),
            array(
                'name' => 'address2',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '<div class="btn-group">{view}{update}{delete}{undeleted}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'view' => array(
                        'options' => array(
                            'class' => 'btn btn-xs btn-success',
                        ),
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'Yii::app()->user->checkAccess("employee.update")',
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("employee.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Undo Delete Item'),
                        'url' => 'Yii::app()->createUrl("Employee/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("employee.delete")',
                    ),
                ),
            ),
        );
    }

    protected function gridLoginIDColumn($data, $row)
    {
        $model = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => $data->id));

        echo ucwords($model->user_name);
    }
}
