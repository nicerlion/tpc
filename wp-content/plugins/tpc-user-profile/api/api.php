<?php

include_once 'base.php';
include_once 'class-product.php';
include_once 'class-common.php';
include_once 'class-customer.php';
include_once 'class-order.php';
include_once 'class-upsell.php';
include_once 'class-gateway.php';

/*
*
* Register the routes for the objects of the controller.
*
*/
function tpc_register_routes() {
    TPC_Products_Endpoints::tpc_register_routes();
    TPC_Common_Endpoints::tpc_register_routes();
    TPC_Customer_Endpoints::tpc_register_routes();
    TPC_Order_Endpoints::tpc_register_routes();
    TPC_Upsell_Endpoints::tpc_register_routes();
    TPC_Gateway_Endpoints::tpc_register_routes();
}

?>
