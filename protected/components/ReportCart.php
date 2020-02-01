<?php
if (!defined('YII_PATH')) {
    exit('No direct script access allowed');
}

class ReportCart extends CApplicationComponent
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

    public function getSaleInvPeriod()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['rpt_saleinv_period'])) {
            $this->setSaleInvPeriod('today');
        }
        return $this->session['rpt_saleinv_period'];
    }

    public function setSaleInvPeriod($data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['rpt_saleinv_period'] = $data;
    }
    
    public function clearSaleInvPeriod()
    {
        $this->setSession(Yii::app()->session);
        unset($this->session['rpt_saleinv_period']);
    }
    
    public function clearAll()
    {
        $this->clearSaleInvPeriod();
    }

}

?>
