<?php
Class Common 
{
    public static function Discount($discount) {
        if (substr($discount, 0, 1) == '$') {
            $discount_amount = substr($discount, 1);
            $discount_type = '$';
        } else {
            $discount_amount = $discount;
            $discount_type = '%';
        }
        
        return array($discount_amount, $discount_type);
    }

    /*
   * To Calculate Total Amount after discount
   */
    public static function calTotalAfterDiscount($discount,$price,$qty=1) {
        $total = 0;
        if (substr($discount, 0, 1) == '$') {
            $total+=round($price * $qty - substr($discount, 1), Common::getDecimalPlace(), PHP_ROUND_HALF_DOWN);
        } else {
            $total+=round($price * $qty - $price * $qty * $discount / 100, Common::getDecimalPlace(), PHP_ROUND_HALF_DOWN);
        }
        return $total;
    }

    /*
     * To Calculate actual discount amount comparing to Total Value
     */
    public static function calDiscountAmount($discount,$price) {
        //$total = 0;
        if (substr($discount, 0, 1) == '$') {
            $total=round(substr($discount, 1), Common::getDecimalPlace(), PHP_ROUND_HALF_DOWN);
        } else {
            $total=round($price * $discount / 100, Common::getDecimalPlace(), PHP_ROUND_HALF_DOWN);
        }
        return $total;
    }

    public static function arrayFactory($type, $code = null)
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
            'page_size' => array(
                10 => 10,
                20 => 20,
                50 => 50,
                100 => 100,
                200 => 200,
                300 => 300,
                500 => 500,
                1000 => 1000,
            ),
            'size_biz' => array(
                'big wholesale' => 'លក់ដុំធំ',
                'medium wholesale' => 'លក់ដុំមធ្យម',
                'medium retail' => 'លក់រាយមធ្យម',
                'small retail' => 'លក់រាយតូច'
            ),
            'main_biz' => array(
                'beverage no alcohol' => 'ភេសជ្ជៈអាកុល',
                'beverage with alcohol' => 'ភេសជ្ជៈមិនមានអាកុល',
                'grocery' => 'នំចំណី',
                'cosmetic' => 'គ្រឿងសំអាង'
            ),
            'invoice_format' => array(
                'format1' => 'No logo no VAT',
                'format2' => 'Logo no VAT',
                'format3' => 'Logo & VAT',
            ), //https://goo.gl/tkYZR1
            'payment_term' => array(
                'COD' => 'ឱ្យលុយភ្លាម',
//                'NET3' => 'ជំពាក់ 3ថ្ងៃ',
//                'NET5' => 'ជំពាក់ 5ថ្ងៃ',
                'NE7' => 'ជំពាក់ 7ថ្ងៃ',
                'NE14' => 'ជំពាក់ 14ថ្ងៃ',
//                'NET30' => 'ជំពាក់ ៣០ថ្ងៃ',
//                'EOM' => 'បង់លុយចុងខែ',
//                'CONSIGN' => 'CONSIGN'
            ),
            /*
            'payment_term' => array(
                'COD' => t('Cash on delivery','app'),
                'CONSIGN' => t('Consignment','app'),
                'NET3' => t('Payment 3 days after invoice date','app'),
                'NET5' => t('Payment 5 days after invoice date','app'),
                'NE7' => t('Payment 7 days after invoice date','app'),
                'NET30' => t('Payment 30 days after invoice date','app'),
                'NET60' => t('Payment 60 days after invoice date','app'),
                'PID' => t('Payment in advance','app'),
                'EOM' => t('End of month','app'),
                'CND' => t('Cash next delivery','app'),
                'CBS' => t('Cash before shipment','app'),
                'CIA' => t('Cash in advance','app'),
                //'CONTRA' => t('Payment from the customer offset against the value of supplies purchased from the customer','app'),
                'STAGE' => t('Payment of agreed amounts at stage','app'),
            ),
            */
            'inv_number_interval' => array(
                'i' => 'Every Minute',
                'H' => 'Every Hour',
                'd' => 'Every day',
                'm' => 'Every month',
                'Y' => 'Every Year'
            ),
        );

        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else {
            return isset($_items[$type]) ? $_items[$type] : false;
        }
    }

    public static function defaultPageSize()
    {
        return Yii::app()->user->getState('pageSize', Yii::app()->settings->get('item', 'itemNumberPerPage'));
    }

    // Convention over configuration principle
    public static function getDecimalPlace()
    {
        return Yii::app()->settings->get('system', 'decimalPlace') == '' ? 2 : Yii::app()->settings->get('system', 'decimalPlace');
    }

    // Invoice Prefixing
    public static function getInvoicePrefix()
    {
        return Yii::app()->settings->get('site', 'invoicePrefix') == '' ? '' : Yii::app()->settings->get('site', 'invoicePrefix');
    }

}