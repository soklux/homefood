# HF Dashboard

## Setup Instruction

* **clone source code**
get clone https://github.com/soklux/homefood.git

* **download Yii1 framwork latest here**
[Source Code (.zip](https://www.yiiframework.com/download#yii1) 

* **create db as db file you own**
not posting here

## Understand the simpe CRUD file & folder stucture

Let's take Outlet List Admin form as example here. 

* Controler  : protetec/controler/OutletController.php
* Model      : protected/model/Outlet.php  
* View       : 
  * List view   : protected/model/out/admin.php
  * Single view : protected/model/out/view.php
  * Create view : protected/model/out/create.php
  * Update view : protected/model/out/update.php

## Understand the dasbhoard simple MVC stucture

### Controller

* DashboardController.php in protected/controller folder

* ReportController.php in protected/controller folder

#### Controller Method actionAgedCustomerPurchase 827:


To display report detail as table $filer pass from Dashboard or Tab Header
```
 public function actionAgedCustomerPurchase($filter = '1')
    {
        //$this->canViewReport();
        authorized('report.stock');

        $grid_id = 'rpt-aged-customer-grid';
        $title = 'Aged Customer Purchase';

        $data = $this->commonData($grid_id,$title,null,'_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getAgedCustomerPurchaseHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getAgedCustomerPurchaseColumns();

        $data['data_provider'] = $data['report']->AgedCustomerPurchase($filter);

        $this->renderView($data);
    }
```

### Model

* protected/modesl/Dashboard.php
* protected/modesl/ReportColumn.php

#### Model method dbAgedPurchase add line 184:

To display in Dashboard PieChart
```
public function dbAgedPurchase()
    {

        $sql = "SELECT ord,aged_purchase,sum(nclient) nclient
                FROM v_aged_customer_purchase
                GROUP BY ord,aged_purchase
                ORDER BY ord";

        return Yii::app()->db->createCommand($sql)->queryAll(true);
    }
```

### View
* **protected/views/dashboard/index.php**
* protected/views/dashboard/partial/widget_agedpurchase.php
* protected/views/dashboard/widget_chart.php
* protected/views/dashboard/widget_topten.php

Each partial view show each block of dashboard widget
