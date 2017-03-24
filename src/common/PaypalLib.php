<?php

namespace vimuths123\larapal\comman;

class PaypalLib {

    static $production_url = 'https://www.paypal.com/cgi-bin/webscr?';
    static $sandbox_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
    static $currency_code = 'US';
    static $merchant_email = 'you@your.com';
    static $tax_1 = false;
    static $shipping_1 = false;
    static $items = array();
    static $userDetails = false;
    static $action = "";

    public static function config($type, $merchant_email, $currency_code) {
        if ($type === 'production') {
            self::$action = 'https://www.paypal.com/cgi-bin/webscr?';
        } else if ($type === 'sandbox') {
            self::$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
        }

        self::$merchant_email = $merchant_email;
        self::$currency_code = $currency_code;
    }

    public static function addTax($tax) {
        self::$tax_1 = $tax;
    }

    public static function addShipping($shippng) {
        self::$shipping_1 = $shippng;
    }

    public static function setItems($items) {
        self::$items = $items;
    }

    public static function setUserDetails($userDetails) {
        self::$userDetails = $userDetails;
    }

    public static function pay() {
        //        Create paypal form
        $form = '';
        $form .= '<form name="frm_payment_method" action="' . self::$action . '" method="post">';
        $form .= '<input type = "hidden" name = "cmd" value = "_cart">';
        $form .= '<input type = "hidden" name = "upload" value = "1">';
        $form .= '<input type = "hidden" name = "business" value = "' . self::$merchant_email . '">';
        
        if (self::$userDetails) {
            if (array_key_exists('first_name', self::$userDetails)) {
                $form .= '<input type="hidden" name="first_name" value="' . self::$userDetails['first_name'] . '">';
            }
            if (array_key_exists('last_name', self::$userDetails)) {
                $form .= '<input type="hidden" name="last_name" value="' . self::$userDetails['last_name'] . '">';
            }
            if (array_key_exists('address1', self::$userDetails)) {
              $form .= '<input type="hidden" name="address1" value="' . self::$userDetails['address1'] . '">';
            }
            if (array_key_exists('address2', self::$userDetails)) {
              $form .= '<input type="hidden" name="address2" value="' . self::$userDetails['address2'] . '">';
            }
            if (array_key_exists('city', self::$userDetails)) {
                $form .= '<input type="hidden" name="city" value="' . self::$userDetails['city'] . '">';
            }
            if (array_key_exists('state', self::$userDetails)) {
                $form .= '<input type="hidden" name="state" value="' . self::$userDetails['state'] . '">';
            }
            if (array_key_exists('zip', self::$userDetails)) {
                $form .= '<input type="hidden" name="zip" value="' . self::$userDetails['zip'] . '">';
            }            

        }

        $form .= '<INPUT TYPE="hidden" NAME="return" value="www.google.lk">';
//        $form .= '<input type="hidden" name="thanks_page" value="www.google.lk">';
//        $form .= '<input type="hidden" name="notify_url" value="www.google.lk">';
//        $form .= '<input type="hidden" name="cancel_url" value="www.google.lk">';

        if (self::$shipping_1) {
            $form .= '<input type = "hidden" name = "shipping_1" value = "' . self::$shipping_1 . '">';
        }

        if (self::$tax_1) {
            $form .= '<input type = "hidden" name = "tax_1" value = "' . self::$tax_1 . '">';
        }

        $x = 1;
        foreach (self::$items as $item) {
            $form .= '<input type = "hidden" name = "item_name_' . $x . '" value = "' . $item['title'] . '">';
            $form .= '<input type = "hidden" name = "quantity_' . $x . '" value = "' . $item['quantity'] . '">';
            $form .= '<input type = "hidden" name = "amount_' . $x . '" value = "' . $item['price'] . '">';
            $x++;
        }

        $form .= '<script>';
        $form .= 'setTimeout("document.frm_payment_method.submit()", 2);';
        $form .= '</script>';
        $form .= '</form>';

        return $form;
    }

    public static function test() {
        return self::$tax_1;
    }

}
