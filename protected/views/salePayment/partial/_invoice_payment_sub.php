<?php if ($client_id==Null) { ?>


    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'above',
        'tabs' => array(
            array('label' => Yii::t('app', 'Outstanding Invoices'), 'id' => 'tab_1', 'content' => 'Searching a customer to find his/her outstanding balance..', 'active' => true),
            array('label' => Yii::t('app', 'Paid Invoice'), 'id' => 'tab_2', 'content' => ''),
            array('label' => Yii::t('app', 'Payment History'), 'id' => 'tab_3', 'content' => ''),
        ),
    ));

    ?>

<?php }else { ?>

    <?php $this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'placement' => 'above',
        'tabs' => array(
            array('label' => Yii::t('app', 'Outstanding Invoices'), 'id' => 'tab_1', 'content' => $this->renderPartial('partial/_invoice', array('model' => $model, 'client_id' => $client_id, 'balance' => $balance), true), 'active' => true),
            array('label' => Yii::t('app', 'Paid Invoice'), 'id' => 'tab_2', 'content' => $this->renderPartial('partial/_invoice_his', array('model' => $model, 'client_id' => $client_id, 'balance' => $balance), true)),
            array('label' => Yii::t('app', 'Payment History'), 'id' => 'tab_3', 'content' => $this->renderPartial('partial/_sale_payment', array('model' => $model, 'client_id' => $client_id, 'balance' => $balance), true)),
        ),
    ));

    ?>

<?php }
