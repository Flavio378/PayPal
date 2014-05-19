<?php
// ==================================
// PayPal Express Checkout Module
// ==================================
namespace PayPalLib;
use PayPalLib\PayPal;
include_once('PayPal.php');
class ExpressCheckout{
    
    //' The currencyCodeType and paymentType 
    //' are set to the selections made on the Integration Assistant 
    //'------------------------------------

    public $currencyCodeType = "MXN";

    public $paymentType = "Sale";
    
   
    public function doCheckout($productos, $costo_envio, $iva, $returnUrl, $cancelUrl, $metodoEnvio){
        //'------------------------------------
        //' Calls the SetExpressCheckout API call
        //'
        //' The CallShortcutExpressCheckout function is defined in the file PayPalFunctions.php,
        //' it is included at the top of this file.
        //'-------------------------------------------------

        $paypal = new PayPal();
        
        $resArray = $paypal->CallShortcutExpressCheckout(
            $this->currencyCodeType,
            $this->paymentType,
            $returnUrl, // return url
            $cancelUrl, // cancel url
            $productos,
            $costo_envio,
            $iva,
            $metodoEnvio
        );
        
        $ack = strtoupper($resArray["ACK"]);
        
        if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
            
            $paypal->RedirectToPayPal($resArray["TOKEN"]);
            
        } else {
            
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
            $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
            $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
            $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

            echo "SetExpressCheckout API call failed. ";
            echo "Detailed Error Message: " . $ErrorLongMsg;
            echo "Short Error Message: " . $ErrorShortMsg;
            echo "Error Code: " . $ErrorCode;
            echo "Error Severity Code: " . $ErrorSeverityCode;
        }
    }
 
}
?>