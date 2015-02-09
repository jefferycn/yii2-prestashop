<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id_order
 * @property integer $id_carrier
 * @property integer $id_lang
 * @property integer $id_customer
 * @property integer $id_cart
 * @property integer $id_currency
 * @property integer $id_address_delivery
 * @property integer $id_address_invoice
 * @property string $secure_key
 * @property string $payment
 * @property string $conversion_rate
 * @property string $module
 * @property integer $recyclable
 * @property integer $gift
 * @property string $gift_message
 * @property string $shipping_number
 * @property string $total_discounts
 * @property string $total_paid
 * @property string $total_paid_real
 * @property string $total_products
 * @property string $total_products_wt
 * @property string $total_shipping
 * @property string $carrier_tax_rate
 * @property string $total_wrapping
 * @property integer $invoice_number
 * @property integer $delivery_number
 * @property string $invoice_date
 * @property string $delivery_date
 * @property string $shipment_date
 * @property integer $valid
 * @property string $date_add
 * @property string $date_upd
 * @property integer $id_subscription
 * @property integer $id_creditcard_info
 * @property integer $id_fulfillment_option
 * @property integer $fulfillment_status
 * @property integer $id_orders_group
 * @property integer $id_card_message_category
 * @property string $fulfillment_date
 * @property integer $delivery_option
 * @property integer $delivery_notify_exception
 * @property integer $email_recipient
 * @property integer $is_b2b
 * @property integer $id_subscription_payment
 *
 * @property OrderTrail[] $orderTrails
 * @property StorecreditLog[] $storecreditLogs
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_carrier', 'id_lang', 'id_customer', 'id_cart', 'id_currency', 'id_address_delivery', 'id_address_invoice', 'payment', 'invoice_date', 'delivery_date', 'date_add', 'date_upd'], 'required'],
            [['id_carrier', 'id_lang', 'id_customer', 'id_cart', 'id_currency', 'id_address_delivery', 'id_address_invoice', 'recyclable', 'gift', 'invoice_number', 'delivery_number', 'valid', 'id_subscription', 'id_creditcard_info', 'id_fulfillment_option', 'fulfillment_status', 'id_orders_group', 'id_card_message_category', 'delivery_option', 'delivery_notify_exception', 'email_recipient', 'is_b2b', 'id_subscription_payment'], 'integer'],
            [['conversion_rate', 'total_discounts', 'total_paid', 'total_paid_real', 'total_products', 'total_products_wt', 'total_shipping', 'carrier_tax_rate', 'total_wrapping'], 'number'],
            [['gift_message'], 'string'],
            [['invoice_date', 'delivery_date', 'shipment_date', 'date_add', 'date_upd', 'fulfillment_date'], 'safe'],
            [['secure_key', 'shipping_number'], 'string', 'max' => 32],
            [['payment', 'module'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_order' => 'Id Order',
            'id_carrier' => 'Id Carrier',
            'id_lang' => 'Id Lang',
            'id_customer' => 'Id Customer',
            'id_cart' => 'Id Cart',
            'id_currency' => 'Id Currency',
            'id_address_delivery' => 'Id Address Delivery',
            'id_address_invoice' => 'Id Address Invoice',
            'secure_key' => 'Secure Key',
            'payment' => 'Payment',
            'conversion_rate' => 'Conversion Rate',
            'module' => 'Module',
            'recyclable' => 'Recyclable',
            'gift' => 'Gift',
            'gift_message' => 'Gift Message',
            'shipping_number' => 'Shipping Number',
            'total_discounts' => 'Total Discounts',
            'total_paid' => 'Total Paid',
            'total_paid_real' => 'Total Paid Real',
            'total_products' => 'Total Products',
            'total_products_wt' => 'Total Products Wt',
            'total_shipping' => 'Total Shipping',
            'carrier_tax_rate' => 'Carrier Tax Rate',
            'total_wrapping' => 'Total Wrapping',
            'invoice_number' => 'Invoice Number',
            'delivery_number' => 'Delivery Number',
            'invoice_date' => 'Invoice Date',
            'delivery_date' => 'Delivery Date',
            'shipment_date' => 'Shipment Date',
            'valid' => 'Valid',
            'date_add' => 'Date Add',
            'date_upd' => 'Date Upd',
            'id_subscription' => 'Id Subscription',
            'id_creditcard_info' => 'Id Creditcard Info',
            'id_fulfillment_option' => 'Id Fulfillment Option',
            'fulfillment_status' => 'Fulfillment Status',
            'id_orders_group' => 'Id Orders Group',
            'id_card_message_category' => 'Id Card Message Category',
            'fulfillment_date' => 'Fulfillment Date',
            'delivery_option' => 'Delivery Option',
            'delivery_notify_exception' => 'Delivery Notify Exception',
            'email_recipient' => 'Email Recipient',
            'is_b2b' => 'Is B2b',
            'id_subscription_payment' => 'Id Subscription Payment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderTrails()
    {
        return $this->hasMany(OrderTrail::className(), ['id_order' => 'id_order']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorecreditLogs()
    {
        return $this->hasMany(StorecreditLog::className(), ['id_order' => 'id_order']);
    }
}
