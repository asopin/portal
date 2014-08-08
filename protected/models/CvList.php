<?php

/**
 * This is the model class for table "cv_list".
 *
 * The followings are the available columns in table 'cv_list':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $marital_status
 * @property string $birth_date
 * @property string $contact_phone
 * @property string $other_contacts
 * @property string $email
 * @property integer $education
 * @property string $eduction_info
 * @property string $work_experience
 * @property string $skills
 * @property string $summary
 * @property string $desired_position
 * @property string $salary
 * @property string $documents
 * @property string $applicant_type
 * @property string $cv_file
 * @property integer $recruiter_id
 * @property string $recruiter_comments
 * @property string $who_filled
 * @property string $last_update
 * @property string $added_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $recruiter
 * @property CvCategories[] $categories
 * @property CvStatuses[] $cvStatuses
 * @property AssistanceTypes[] $assistanceTypes
 * @property CitiesList[] $citiesResidence
 * @property CitiesList[] $citiesJobLocations
 */
class CvList extends CActiveRecord
{   
    public $genderTypes = array();
    public $categoryIds = array();
    public $driverLicensesIds = array();
    public $educationTypes = array();
    public $statusTypes = array();
    public $assistanceIds = array();
    public $residenciesIds = array();
    public $jobLocationsIds = array();
    public $maritalStatuses = array();
    
    public $personal_data;

    public function __construct()
    {
        $controller = Yii::app()->getController();
        $this->genderTypes = $controller->loadConfigFromFile('gender_types');
        $this->educationTypes = $controller->loadConfigFromFile('education_types');
        $this->statusTypes = $controller->loadConfigFromFile('statuses');
        $this->maritalStatuses = $controller->loadConfigFromFile('marital_statuses');
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cv_list';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name, last_name, gender, birth_date, contact_phone, education, eduction_info, residenciesIds, jobLocationsIds, work_experience, desired_position, documents, applicant_type, recruiter_id', 'required'),
            array('personal_data', 'compare', 'compareValue' => true, 'message' => 'Вам потрібно погодитись надати свої персональні дані', 'on' => 'public'),
            array('education, recruiter_id, status', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, desired_position, cv_file, who_filled', 'length', 'max' => 255),
            array('gender', 'length', 'max' => 1),
            array('email', 'email'),
            array('contact_phone', 'length', 'max' => 19),
            array('salary', 'safe'),
            array('id, category_id, first_name, last_name, gender, birth_date, contact_phone, email, education, eduction_info, work_experience, skills, summary, desired_position, documents, applicant_type, cv_file, recruiter_id, recruiter_comments, who_filled, added_time, status', 'safe', 'on' => 'search'),
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
            'recruiter' => array(self::BELONGS_TO, 'User', 'recruiter_id'),
            'cvStatuses' => array(self::HAS_MANY, 'CvStatuses', 'cv_id'),
            'categories' => array(self::MANY_MANY, 'CvCategories', 'cv_to_category(cv_id, category_id)'),
            'driverLicensesTypes' => array(self::MANY_MANY, 'DriverLicenses', 'cv_to_driver_license(cv_id, license_id)'),
            'assistanceTypes' => array(self::MANY_MANY, 'AssistanceTypes', 'cv_to_assistance(cv_id, assistance_type_id)'),
            'citiesResidence' => array(self::MANY_MANY, 'CitiesList', 'cv_to_residence(cv_id, city_id)'),
            'citiesJobLocations' => array(self::MANY_MANY, 'CitiesList', 'cv_to_job_location(cv_id, city_id)'),
        );
    }

    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'categoryIds' => 'Категорії',
            'first_name' => 'Ім’я',
            'last_name' => 'Призвище',
            'first_last_name' => 'Ім’я Призвище',
            'gender' => 'Стать',
            'marital_status' => 'Сімейний стан',
            'birth_date' => 'Дата народження',
            'contact_phone' => 'Телефон',
            'other_contacts' => 'Інші контакти',
            'email' => 'Електронна пошта',
            'education' => 'Освіта',
            'eduction_info' => 'Про освіту',
            'work_experience' => 'Досвід роботи',
            'skills' => 'Навички',
            'summary' => 'Резюме',
            'desired_position' => 'Бажана позиція',
            'salary' => 'Побажання по зар.платні',
            'jobLocationsIds' => 'Бажане місце роботи',
            'documents' => 'Наявні документи (паспорт, права, диплом, трудова книжка)',
            'driverLicensesIds' => 'Водійські права',
            'applicant_type' => 'Інформація про претендента ЦЗВЛ',
            'assistanceIds' => 'Потрібна допомога',
            'residenciesIds' => 'Місце проживання',
            'cv_file' => 'Файл резюме (посилання)',
            'recruiter_id' => 'Рекрутер',
            'recruiter_comments' => 'Коментарі рекрутера',
            'statuses' => 'Історія',
            'who_filled' => 'Хто заповнив',
            'added_time' => 'Додано',
            'status' => 'Стан',
            'personal_data' => 'Я згоден(на) з обробкою та використанням моїх персональних даних'
        );
    }
    
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord && !Yii::app()->user->isGuest) {
                $this->who_filled = Yii::app()->user->id;
            }
            $this->last_update = new CDbExpression('NOW()');
            $this->contact_phone = preg_replace('/[^0-9]/', '', $this->contact_phone);
            return true;
        } else {
            return false;
        }
    }
    
    public function afterFind()
    {
        parent::afterFind();
        
        if (empty($this->residenciesIds)) {
            foreach ($this->citiesResidence as $name) {
                $this->residenciesIds[] = $name->city_index;
            }
        }
        if (empty($this->assistanceIds)) {
            foreach ($this->assistanceTypes as $a) {
                $this->assistanceIds[] = $a->id;
            }
        }
        if (empty($this->jobLocationsIds)) {
            foreach ($this->citiesJobLocations as $j) {
                $this->jobLocationsIds[] = $j->city_index;
            }
        }
        if (empty($this->categoryIds)) {
            foreach ($this->categories as $c) {
                $this->categoryIds[] = $c->id;
            }
        }
        if (empty($this->driverLicensesIds)) {
            foreach ($this->driverLicensesTypes as $d) {
                $this->driverLicensesIds[] = $d->id;
            }
            
        }
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

        $criteria->compare('id', $this->id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('contact_phone', $this->contact_phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('education', $this->education);
        $criteria->compare('eduction_info', $this->eduction_info, true);
        $criteria->compare('work_experience', $this->work_experience, true);
        $criteria->compare('skills', $this->skills, true);
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('desired_position', $this->desired_position, true);
        $criteria->compare('documents', $this->documents, true);
        $criteria->compare('applicant_type', $this->applicant_type, true);
        $criteria->compare('cv_file', $this->cv_file, true);
        $criteria->compare('recruiter_id', $this->recruiter_id);
        $criteria->compare('recruiter_comments', $this->recruiter_comments, true);
        $criteria->compare('who_filled', $this->who_filled, true);
        $criteria->compare('added_time', $this->added_time, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CvList the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function getAssistances()
    {
        $html = '';
        if (is_array($this->assistanceTypes)) {
            $html = '<ul>';
            foreach ($this->assistanceTypes as $a) {
                $html .= "<li>" . $a->name . "</li>";
            }
            $html .= '</ul>';
        }
        return $html;
        
    }
    
    public function getLatestStatus()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'cv_id = :cv_id';
        $criteria->params = array(':cv_id' => $this->id);
        $criteria->order = "id DESC";
        $criteria->limit = 1;
        
        return CvStatuses::model()->find($criteria);
    }
    
    public function getFirstLastName()
    {
        return $this->first_name . " " . $this->last_name;
    }

}