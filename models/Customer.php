<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id_customer
 * @property integer $id_gender
 * @property integer $id_default_group
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $passwd
 * @property string $last_passwd_gen
 * @property string $birthday
 * @property integer $newsletter
 * @property string $ip_registration_newsletter
 * @property integer $id_customer_class
 * @property string $newsletter_date_add
 * @property integer $optin
 * @property string $secure_key
 * @property string $note
 * @property integer $active
 * @property integer $is_b2b
 * @property integer $is_guest
 * @property integer $deleted
 * @property string $reference1
 * @property string $reference2
 * @property string $id_related_idme
 * @property string $hash_id
 * @property string $date_add
 * @property string $date_upd
 *
 * @property CartGroup[] $cartGroups
 * @property CreditcardInfo[] $creditcardInfos
 * @property CustomerLink[] $customerLinks
 * @property OrderimportBatch[] $orderimportBatches
 * @property Storecredit[] $storecredits
 * @property StorecreditLog[] $storecreditLogs
 * @property Subscription[] $subscriptions
 * @property SubscriptionDiscount[] $subscriptionDiscounts
 */
class Customer extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_gender', 'firstname', 'lastname', 'email', 'passwd', 'id_customer_class', 'date_add', 'date_upd'], 'required'],
            [['id_gender', 'id_default_group', 'newsletter', 'id_customer_class', 'optin', 'active', 'is_b2b', 'is_guest', 'deleted'], 'integer'],
            [['last_passwd_gen', 'birthday', 'newsletter_date_add', 'date_add', 'date_upd'], 'safe'],
            [['note'], 'string'],
            [['firstname', 'lastname', 'passwd', 'secure_key', 'reference1', 'reference2', 'hash_id'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 128],
            [['ip_registration_newsletter'], 'string', 'max' => 46],
            [['id_related_idme'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_customer' => 'Id Customer',
            'id_gender' => 'Id Gender',
            'id_default_group' => 'Id Default Group',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'passwd' => 'Passwd',
            'last_passwd_gen' => 'Last Passwd Gen',
            'birthday' => 'Birthday',
            'newsletter' => 'Newsletter',
            'ip_registration_newsletter' => 'Ip Registration Newsletter',
            'id_customer_class' => 'Id Customer Class',
            'newsletter_date_add' => 'Newsletter Date Add',
            'optin' => 'Optin',
            'secure_key' => 'Secure Key',
            'note' => 'Note',
            'active' => 'Active',
            'is_b2b' => 'Is B2b',
            'is_guest' => 'Is Guest',
            'deleted' => 'Deleted',
            'reference1' => 'Reference1',
            'reference2' => 'Reference2',
            'id_related_idme' => 'Id Related Idme',
            'hash_id' => 'Hash ID',
            'date_add' => 'Date Add',
            'date_upd' => 'Date Upd',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartGroups()
    {
        return $this->hasMany(CartGroup::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditcardInfos()
    {
        return $this->hasMany(CreditcardInfo::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerLinks()
    {
        return $this->hasMany(CustomerLink::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderimportBatches()
    {
        return $this->hasMany(OrderimportBatch::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorecredits()
    {
        return $this->hasMany(Storecredit::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorecreditLogs()
    {
        return $this->hasMany(StorecreditLog::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionDiscounts()
    {
        return $this->hasMany(SubscriptionDiscount::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //       return static::findOne(['access_token' => $token]);
    // }
 
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->secure_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5(pSQL(_COOKIE_KEY_.$password));
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
