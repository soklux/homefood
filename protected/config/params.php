<?php

// this contains the application parameters that can be maintained via GUI
return array(
    // this is used in contact page
    'adminEmail' => 'support@peedor.com',
    'sale_cancel_status' => '0', // Sale Cancel/Deleted
    'sale_complete_status' => '1', // Sale Order Complete - When all details are entered and no further changes are required.
    'sale_submit_status' => '2', // Sale Order Submit For Validate/Review - stock mark as allocated for this order
    'sale_invalid_status' => '-2', // Sale Order Invalid
    'sale_validate_status' => '3', // Sale order Validated by Sale person (Sale manager or supervisor) after validate sale cannot be  change by him
    'sale_reject_status' => '-3', // Sale Order Rejected
    'sale_confirm_status' => '4', // Sale Order Confirmed by Account / Finance team - Ready to delivery
    'sale_do_status' => '5', // Print Delivery Note
    'sale_print_status' => '6', // Print / Reprint Invoice
	'sale_delivery_status' => '7', // When product ready to be deliver
    'active_status' => '1',
    'inactive_status' => '0',
    'defaultArchived' => 'false',
	'create_customer_cancel_status' => '0', //Cancel or delete create customer
	'create_customer_complete_status' => '1', //When Customer created was approved
	'create_customer_submit_status' => '2',//Submit to create customer and waiting approval
	'create_customer_reject_status' => '-2',//Customer request to create was rejected
    'biz_name' => 'Magic Qeen',
    'biz_title' => 'system',
    // this is displayed in the header section
	'title' => 'Simply The Best',
	// number of posts displayed per page
	'postsPerPage'=>10,
	// maximum number of comments that can be displayed in recent comments portlet
	'recentCommentCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; 2009 by My Company.',
    // Company Name
    'company_name' => 'Try Me',
    'company_slogan' => 'simply the best',
    'menu_home' => 'home',
    'menu_dashboard' => 'dashboard',
    'menu_item' => 'item',
    'menu_item_add' => 'add item',
    'menu_asseblies_view'=>'Assemblies Item',
    'menu_categories_view'=>'Categories',
    'menu_pricebook_view'=>'Price Book',
    'menu_item_view' => 'view item',
    'menu_item_finder' => 'Item finder',
    'menu_item_imp_exp' => 'Import/Export',
    'menu_item_markup_price' => 'Markup Price Update',
    'menu_inventory' => 'inventory',
    'menu_inventory_count' => 'physical count',
    'menu_inventory_count2' => 'physical count2',
    'menu_inventory_add' => 'in stock',
    'menu_inventory_minus' => 'out stock',
    'menu_inventory_transfer' => 'transfer stock',
    'menu_purchase' => 'purchase',
    'menu_purchase_receive' => 'receive from supplier',
    'menu_purchase_return' => 'return to supplier',
    'menu_purchase_payment' => 'supplier payment',
    'menu_sale' => 'sale',
    'menu_sale_add' => 'add sale order',
    'menu_sale_view' => 'review sale order',
    'menu_sale_approve' => 'approve sale order',
    'menu_sale_payment' => 'payment',
    'menu_sale_order' => 'order', // sale order shot cut to order we continuous main menu Sale
    'menu_sale_order_add' => 'order create', // sale order add => order ad
    'menu_sale_create_invoice'=>'invoice create',
    'menu_sale_order_view' =>  'order view', // sale order view => order view
    'menu_sale_order_to_validate' => 'order to validate',
    'menu_sale_order_to_invoice' => 'order to invoice',
    'menu_sale_order_to_deliver' => 'order to deliver',
    'menu_invoice' => 'invoice',
    'menu_sale_order_approval' => 'Order To Approval',
    'menu_sale_order_history' => 'Sale Order History',
    'menu_invoice_add' => 'invoice create',
    'menu_report' => 'report',
    'menu_report_sale_invoice' => 'sale invoice',
    'menu_report_sale_daily' => 'sale daily',
    'menu_report_sale_hourly' => 'sale hourly',
    'menu_report_sale_summary' => 'sale summary',
    'menu_customer' => 'customer',
    'menu_customer_group' => 'customer group',
    'menu_employee' => 'employee',
    'menu_supplier' => 'supplier',
    'menu_setting' => 'setting',
    'menu_category' => 'category',
    'menu_price_tier' => 'price tier',
    'menu_authorization' => 'authorization',
    'menu_about_us' => 'about us',
    'menu_outlet' => 'Outlet',
	'menu_validate_customer' => 'Customer To Validate'
);
