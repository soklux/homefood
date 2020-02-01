
# Understand the simpe CRUD File & Folder Stucture

## Let's take Outlet List Admin form as example here. 

	* Controler  : protetec/controler/OutletController.php contains the OutletController class which in charge of all CRUD operatons about outlets.
	* Model      : protected/model/Outlet.php  
	* Views      : 
	  * Admin view         : protected/views/outlet/admin.php is the view file that displays outlets in a table / list vie with administrative commands.
	  * Create view 	  : protected/views/outlet/create.php is the view file that show s an HTML form to create a new out let;
	  * Update view 	  : protected/views/outlet/update.php is the view file that show an HTML form to update an existing outlet.
	  * Form View         : protected/views/outlet/_form.php is the partial view file embedded in views/outlet/create.php and views/outlet/
	  * Search View        : protected/views/outlet/_search.php is the partial view file used by views/outlet/admin.php. It displays a search form.
	  * List view        : protected/views/outlet/index.php is the view fiels that display a list of posts no admin functon. This view file has not been use in Homefood web application
	  * Single view 	  : protected/views/outlet/view.php is the view fiel that displays the detailed information of an outlet.
	  update.php. It displays the HTML form for collecting post information.
	  * View view 		   : protected/views/outlet/_view.php is the partial view files used by protected/views/outlet/index.php. It displays the brief view of a single post. This view file has not been use in Homefood web application


## Understand the Dasbhoard & Report File & Folder Stucture 

### Controller

* DashboardController.php in protected/controller folder

* ReportController.php in protected/controller folder

#### Controller Method actionAgedCustomerPurchase 827:


To display report detail as table $filer pass from Dashboard or Tab Header
```
 public function actionAgedCustomerPurchase($filter = '1')
    {
    	
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