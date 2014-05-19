<?php

/* ==================================================================
  PayPal Express Checkout Call
  ===================================================================
 */

namespace PayPalLib;

use PayPalLib\PayPal;

class Confirmation {

    public function ConfirmPayment($ATM, $payer_id, $currecycode, $token) {
        $paypal = new PayPal();
        $resArray = $paypal->ConfirmPayment($ATM, $payer_id, $currecycode, $token);
        $ack = strtoupper($resArray["ACK"]);
        if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") { 
            return $resArray;
        } else {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            $ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
            $ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
            $ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
            $ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

            echo "GetExpressCheckoutDetails API call failed. ";
            echo "Detailed Error Message: " . $ErrorLongMsg;
            echo "Short Error Message: " . $ErrorShortMsg;
            echo "Error Code: " . $ErrorCode;
            echo "Error Severity Code: " . $ErrorSeverityCode;
        }
    }

}
