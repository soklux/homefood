<?php
if (!defined('YII_PATH')) {
    exit('No direct script access allowed');
}

class PaymentCart extends CApplicationComponent
{

    //private $quantity;

    private $session;

    //private $decimal_place;

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($value)
    {
        $this->session = $value;
    }

    public function getClientId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['payment_client_id'])) {
            $this->setClientId(null);
        }
        return $this->session['payment_client_id'];
    }

    public function setClientId($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['payment_client_id'] = $data;
    }
    
    public function removeCustomer()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['payment_client_id']);
    }

    public function getInvoiceId()
{
    $this->setSession(Yii::app()->session);
    if (!isset($this->session['payment_invoice_id'])) {
        $this->setInvoiceId(null);
    }
    return $this->session['payment_invoice_id'];
}

    public function setInvoiceId($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['payment_invoice_id'] = $data;
    }

    public function removeInvoiceId()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['payment_invoice_id']);
    }

    public function getInvoiceBalance()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['payment_invoice_balance'])) {
            $this->setInvoiceId(null);
        }
        return $this->session['payment_invoice_balance'];
    }

    public function setInvoiceBalance($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['payment_invoice_balance'] = $data;
    }

    public function removeInvoiceBalance()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['payment_invoice_balance']);
    }

    public function clearInvoice()
    {
        $this->removeInvoiceId();
        $this->removeInvoiceBalance();
    }
    
    public function clearAll()
    {
        $this->removeCustomer();
        $this->removeInvoiceId();
        $this->removeInvoiceBalance();
    }

}

