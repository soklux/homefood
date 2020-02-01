<?php

if (!defined('YII_PATH'))
    exit('No direct script access allowed');

class ItemCart extends CApplicationComponent
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


    public function getCart()
    {
        $this->setSession(Yii::app()->session);
        if (!isset($this->session['cart'])) {
            $this->setCart(array());
        }
        return $this->session['cart'];
    }

    public function setCart($cart_data)
    {
        $this->setSession(Yii::app()->session);
        $this->session['cart'] = $cart_data;
        //$session=Yii::app()->session;
        //$session['cart']=$cart_data;
    }

    public function addItemPriceQty($item_id, $from_qty, $to_qty, $price = null, $start_date = null, $end_date = null)
    {
        $this->setSession(Yii::app()->session);
        //Get all items in the cart so far...
        $items = $this->getCart();
           
        //try to get item id given an item_number
        if (empty($models)) {
            $models = Item::model()->getItemPriceTierItemNum($item_id, $this->getPriceTier());
            foreach ($models as $model) {
                $item_id=$model["id"];
            }
        }

        if (!$models) {
            return false;
        }

        foreach ($models as $model) {
        
            $item_data = array((int)$item_id =>
                array(
                    'item_id' => $model["id"],
                    'name' => $model["name"],
                    'item_number' => $model["item_number"],
                    'quantity' => $quantity,
                    'price' => $price!= null ? round($price, Common::getDecimalPlace()) : round($model["unit_price"], Common::getDecimalPlace()),
                    'discount' => $discount,
                    'expire_date' => $expire_date,
                    'description' => $description!= null ? $description : $model["description"],
                    'unit_measurable' => $model['unit_measurable'],
                )
            );
        }

        if (isset($items[$item_id])) {
            $items[$item_id]['quantity']+=$quantity;
        } else {
            $items += $item_data;
        }
        
        $this->setCart($items);
        return true;
    }

    public function clearAll()
    {
        $this->emptyCart();
        $this->emptyPayment();
        $this->removeCustomer();
        $this->clearComment();
        $this->clearSaleId();
        $this->clearSaleTime();
        $this->removeEmployee();
        $this->clearPriceTier();
        $this->clearTotalDiscount();
        $this->clearPaymentNote();
        $this->clearTotalGST();
        $this->clearSaleRep();
        $this->clearSaleMode();
    }

}
