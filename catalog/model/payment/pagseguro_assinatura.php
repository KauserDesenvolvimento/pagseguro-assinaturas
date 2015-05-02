<?php

class ModelPaymentPagseguroAssinatura extends Model
{
    public function getMethod($address, $total)
    {
        $this->language->load('payment/pagseguro_assinatura');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('pagseguro_assinatura_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        $method_data = array();

        if (!$this->config->get('pagseguro_assinatura_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        if ($this->config->get('pagseguro_assinatura_status') < 1) {
            $status = false;
        }

        if ($total > 2000) {
            $status = false;
        }
        if ($status) {
            $method_data = array(
                'code'       => 'pagseguro_assinatura',
                'title'      => 'Assinar esta compra',
                'sort_order' => $this->config->get('pagseguro_assinatura_sort_order'),
            );
        }

        return $method_data;
    }
}
