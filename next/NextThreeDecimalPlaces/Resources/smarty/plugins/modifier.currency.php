<?php

function smarty_modifier_currency($value, $config = null, $position = null)
{
    if (!Shopware()->Container()->has('Currency')) {
        return $value;
    }

    if (!empty($config) && is_string($config)) {
        $config = strtoupper($config);
        if (defined('Zend_Currency::' . $config)) {
            $config = array('display' => constant('Zend_Currency::' . $config));
        } else {
            $config = array();
        }
    } else {
        $config = array();
    }

    if (!empty($position) && is_string($position)) {
        $position = strtoupper($position);
        if (defined('Zend_Currency::' . $position)) {
            $config['position'] = constant('Zend_Currency::' . $position);
        }
    }
    $config['precision'] = 3;
    $currency = Shopware()->Container()->get('Currency');
    $value = floatval(str_replace(',', '.', $value));
    $value = $currency->toCurrency($value, $config);
    $value = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
    $value = htmlentities($value, ENT_COMPAT, 'UTF-8', false);
    return $value;
}
