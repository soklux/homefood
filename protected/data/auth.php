<?php

$auth = Yii::app()->authManager;

// add "Sale Order" permission
$auth->createOperation('createSale','create a sale order');
$auth->createOperation('readSale','read a sale order');
$auth->createOperation('readAllSale','read all sale order');
$auth->createOperation('updateSale','update a sale order');
$auth->createOperation('deleteSale','delete a sale order');
$auth->createOperation('reviewSale','review a sale order');
$auth->createOperation('approveSale','approve a sale order');

// Add "Sale Payment" permission
$auth->createOperation('paymentSale','payment a sale order');

// add "Purchase Order" permission
$auth->createOperation('createPurchase','create a purchase order');
$auth->createOperation('readPurchase','read a purchase order');
$auth->createOperation('updatePurchase','update a purchase order');
$auth->createOperation('deletePurchase','delete a purchase order');
$auth->createOperation('receivePurchase','receive a purchase order');
$auth->createOperation('returnPurchase','return a purchase order');
$auth->createOperation('reviewPurchase','review a purchase order');
$auth->createOperation('approvePurchase','approve a purchase order');

// add "Inventory" permission
$auth->createOperation('inStock','in stock');
$auth->createOperation('outStock','out stock');
$auth->createOperation('countStock','count stock');
$auth->createOperation('transferStock','transfer stock');

// add "Report" permission
$auth->createOperation('saleReport','view all sale report');
$auth->createOperation('inventoryReport','view all inventory report');
$auth->createOperation('managementReport','view all management report');
$auth->createOperation('marketingReport','view all marketing');


// add "Item" permission
$auth->createOperation('createItem','create an item');
$auth->createOperation('readItem','read an item');
$auth->createOperation('updateItem','update an item');
$auth->createOperation('deleteItem','delete an item');

// add "Item Setting" permission
$auth->createOperation('updateItemPrice','update an item price');

// add "Customer" permission
$auth->createOperation('createCustomer','create an customer');
$auth->createOperation('readCustomer','read an customer');
$auth->createOperation('updateCustomer','update an customer');
$auth->createOperation('deleteCustomer','delete an customer');

// add "Supplier" permission
$auth->createOperation('createSupplier','create an supplier');
$auth->createOperation('readSupplier','read an supplier');
$auth->createOperation('updateSupplier','update an supplier');
$auth->createOperation('deleteSupplier','delete an supplier');

// Biz rule can update only his own sale order
$bizRule='return Yii::app()->user->id==$params["post"]->authID;';
$task=$auth->createTask('updateOwnSale','update a sale by salesperson himself',$bizRule);
$task->addChild('updateSale');

// Biz rule can view only his own sale order
$bizRule='return Yii::app()->user->id==$params["post"]->authID;';
$task=$auth->createTask('readOwnSale','read a sale by salesperson himself',$bizRule);
$task->addChild('readSale');


$role=$auth->createRole('stockclerk');
$role->addChild('readItem');
$task->addChild('inStock');
$task->addChild('outStock');
$task->addChild('countStock');
$task->addChild('transferStock');
$task->addChild('inventoryReport');

$role=$auth->createRole('salesperson');
$task->addChild('createSale');
$task->addChild('readSale');
$task->addChild('updateSale');
$task->addChild('deleteSale');
$task->addChild('saleReport');

$role=$auth->createRole('salesmanager');
$role->addChild('salesperson');
$role->addChild('readAllSale');
$role->addChild('reviewSale');

$role=$auth->createRole('accountant');
$role->addChild('salesperson');
$role->addChild('approveSale');
$role->addChild('createItem');
$role->addChild('readItem');
$role->addChild('updateItem');
$role->addChild('deleteItem');
$role->addChild('updateItemPrice');
$role->addChild('createCustomer');
$role->addChild('readCustomer');
$role->addChild('updateCustomer');
$role->addChild('deleteCustomer');
$role->addChild('createSupplier');
$role->addChild('readSupplier');
$role->addChild('updateSupplier');
$role->addChild('deleteSupplier');
$role->addChild('paymentSale');

$role=$auth->createRole('admin');
$role->addChild('stockclerk');
$role->addChild('salesmanager');
$role->addChild('accountant');

$auth->assign('admin','super');
