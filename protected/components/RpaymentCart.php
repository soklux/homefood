<?php
if (!defined('YII_PATH')) {
    exit('No direct script access allowed');
}

class RpaymentCart extends CApplicationComponent
{

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

    public function getSupplierId()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['payment_supplier_id'])) {
            $this->setSupplierId(null);
        }
        return $this->session['payment_supplier_id'];
    }

    public function setSupplierId($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['payment_supplier_id'] = $data;
    }
    
    public function removeSupplier()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['payment_supplier_id']);
    }
    
    public function clearAll()
    {
        $this->removeSupplier();
    }

}

