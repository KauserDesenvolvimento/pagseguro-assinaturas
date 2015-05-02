<?php

/**
 * It's a giant cave. Dragons can be found here. Take care adventurers!
 */
class ModelToolAssinaturaHelper extends Model
{
    public function init($email, $token)
    {
        require_once DIR_SYSTEM . 'library/kauser/pagseguro_assinatura.php';

        $pedido = new PagSeguroAssinatura($email, $token);

        return $pedido;
    }

    public function formatName($first, $last)
    {
        $nome = $first . '  ' . $last;
        $nome = $this->formatString($nome, 47);
        return $nome;
    }

    public function phoneArea($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);
        return substr($phone, 0, 2);
    }

    public function phoneNumber($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);
        return substr($phone, 2);
    }

    public function getState($zone_id)
    {
        $this->load->model('localisation/zone');
        $zone = $this->model_localisation_zone->getZone($zone_id);
        return (isset($zone['code'])) ? $zone['code'] : '';
    }

    /*
     * Small baby dragon, feed with some developers.
     */
    public function getPreDetails($pedido)
    {

        $text = 'Plano de assinatura referente ao pedido #' . $pedido;

        return $text;
    }

    /*
     * I Told you about dragons, here is the red one. Ask Khaleesi for help!
     */
    public function formatDate($date)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $date = new DateTime($date);
        $date = $date->format('Y-d-m');
        $date .= 'T' . date('H:i') . ':000-03:00';

        return $date;
    }

    public function decimalFormat($numeric)
    {
        if (is_float($numeric)) {
            $numeric = (float) $numeric;
            $numeric = (string) number_format($numeric, 2, '.', '');
        }
        return $numeric;
    }

    public function removeStringExtraSpaces($string)
    {
        return trim(preg_replace("/( +)/", " ", $string));
    }

    public function truncateValue($string, $limit, $endchars = '...')
    {

        if (!is_array($string) && !is_object($string)) {

            $stringLength   = strlen($string);
            $endcharsLength = strlen($endchars);

            if ($stringLength > (int) $limit) {
                $cut    = (int) ($limit - $endcharsLength);
                $string = substr($string, 0, $cut) . $endchars;
            }
        }
        return $string;
    }

    public function formatString($string, $limit, $endchars = '...')
    {
        $string = $this->removeStringExtraSpaces($string);
        return $this->truncateValue($string, $limit, $endchars);
    }

}
