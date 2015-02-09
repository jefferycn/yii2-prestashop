<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storecredit_log".
 *
 * @property integer $id_storecredit_log
 * @property integer $id_storecredit
 * @property integer $id_customer
 * @property integer $id_order
 * @property string $amount
 * @property string $comment
 * @property string $date_add
 *
 * @property Customer $idCustomer
 * @property Orders $idOrder
 * @property Storecredit $idStorecredit
 */
class StorecreditLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storecredit_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_storecredit', 'id_customer', 'id_order', 'amount', 'date_add'], 'required'],
            [['id_storecredit', 'id_customer', 'id_order'], 'integer'],
            [['amount'], 'number'],
            [['date_add'], 'safe'],
            [['comment'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_storecredit_log' => 'Id Storecredit Log',
            'id_storecredit' => 'Id Storecredit',
            'id_customer' => 'Id Customer',
            'id_order' => 'Id Order',
            'amount' => 'Amount',
            'comment' => 'Comment',
            'date_add' => 'Date Add',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCustomer()
    {
        return $this->hasOne(Customer::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOrder()
    {
        return $this->hasOne(Orders::className(), ['id_order' => 'id_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStorecredit()
    {
        return $this->hasOne(Storecredit::className(), ['id_storecredit' => 'id_storecredit']);
    }
}
