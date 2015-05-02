<?php

class ControllerPaymentPagseguroAssinatura extends Controller
{
    public function index()
    {
        $this->template = 'default/template/payment/pagseguro_assinatura.tpl';
        $this->render();
    }

    /**
     * Receive post from payment front-end and generate pre authorization url. So ugly huh?
     * @return string link to pre authorization
     */
    public function gerarPre()
    {
        $email = $this->config->get('pagseguro_assinatura_email');

        if ("sandbox" == $this->config->get('pagseguro_assinatura_ambiente')) {
            $token = $this->config->get('pagseguro_assinatura_token_sandbox');
        } else {
            $token = $this->config->get('pagseguro_assinatura_token_producao');
        }
        $this->load->model('tool/assinatura_helper');
        $helper = $this->model_tool_assinatura_helper;

        $pedido = $helper->init($email, $token);

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order;

        $order = $order_info->getOrder($this->session->data['order_id']);

        $pedido->setEnvironment($this->config->get('pagseguro_assinatura_ambiente'));
        $pedido->setRedirectURL(HTTP_SERVER . 'index.php?route=checkout/success');
        $pedido->setReviewURL(HTTP_SERVER . 'index.php?route=checkout/checkout');

        $period                   = $_POST['period'];
        $reference                = 'assinatura_' . $order['order_id'];
        $senderName               = $helper->formatName($order['firstname'], $order['lastname']);
        $senderEmail              = $order['email'];
        $senderAreaCode           = $helper->phoneArea($order['telephone']);
        $senderPhone              = $helper->phoneNumber($order['telephone']);
        $senderAddressStreet      = $helper->formatString($order['shipping_address_1'], 77);
        $senderAddressNumber      = '';
        $senderAddressComplement  = '';
        $senderAddressDistrict    = $helper->formatString($order['shipping_address_2'], 57);
        $senderAddressPostalCode  = preg_replace('/\D/', '', $order['shipping_postcode']);
        $senderAddressCity        = $helper->formatString($order['shipping_city'], 57);
        $senderAddressState       = $helper->getState($order['shipping_zone_id']);
        $senderAddressCountry     = 'BRA';
        $approvalCharge           = 'auto';
        $approvalName             = 'Assinatura Personalizada N.' . $order['order_id'];
        $approvalDetails          = $helper->getPreDetails($order['order_id']);
        $approvalAmountPerPayment = number_format($order['total'], 2, '.', '');
        $approvalPeriod           = $_POST['period'];
        $approvalFinalDate        = $helper->formatDate($_POST['data_final']);
        $approvalMaxTotalAmount   = '35000.00';

        $pedido->setReference($reference);
        $pedido->setSenderName($senderName);
        $pedido->setSenderEmail($senderEmail);
        $pedido->setSenderAreaCode($senderAreaCode);
        $pedido->setSenderPhone($senderPhone);
        $pedido->setSenderAddressStreet($senderAddressStreet);
        $pedido->setSenderAddressNumber($senderAddressNumber);
        $pedido->setSenderAddressComplement($senderAddressComplement);
        $pedido->setSenderAddressDistrict($senderAddressDistrict);
        $pedido->setSenderAddressPostalCode($senderAddressPostalCode);
        $pedido->setSenderAddressCity($senderAddressCity);
        $pedido->setSenderAddressState($senderAddressState);
        $pedido->setSenderAddressCountry($senderAddressCountry);
        $pedido->setApprovalCharge($approvalCharge);
        $pedido->setApprovalName($approvalName);
        $pedido->setApprovalDetails($approvalDetails);
        $pedido->setApprovalAmountPerPayment($approvalAmountPerPayment);
        $pedido->setApprovalPeriod($approvalPeriod);
        $pedido->setApprovalFinalDate($approvalFinalDate);
        $pedido->setApprovalMaxTotalAmount($approvalMaxTotalAmount);

        /**
         * Array with profile data, used to register at database. You can leave commented for while.
         * @var array
         */
        $data = array(
            'profile_id'          => $order['order_id'],
            'profile_name'        => $approvalName,
            'profile_details'     => $approvalDetails,
            'profile_amount'      => $approvalAmountPerPayment,
            'profile_period'      => $approvalPeriod,
            'profile_final_date'  => $approvalFinalDate,
            'profile_customer_id' => $order['customer_id'],
            'profile_order_id'    => $order['order_id'],
        );

        $xml = $pedido->registerOrder();
        /**
         * Let's dance!
         */
        $this->confirm($xml->code);

        echo $pedido->location($xml);
    }

    public function confirm($code)
    {
        $this->load->model('checkout/order');

        $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('pagseguro_assinatura_order_status'), 'Code: ' . $code, true);
    }

    /**
     * Here we insert autorizations profile table at database
     * @param  array $data parameters with profile data
     * @return boolean show us what happended there
     */
    public function registrarAssinatura($data)
    {
        // Not implemented yet
        $sql = "INSERT INTO " . DB_PREFIX . "`pagseguro_profile` ( `profile_name` ,  `profile_details` ,  `profile_amount` ,  `profile_period` ,  `profile_final_date` ,  `profile_customer_id` ,  `profile_order_id`  ) VALUES(  '{$data['profile_name']}' ,  '{$data['profile_details']}' ,  '{$data['profile_amount']}' ,  '{$data['profile_period']}' ,  '{$data['profile_final_date']}' ,  '{$data['profile_customer_id']}' ,  '{$data['profile_order_id']}'  ) ";

        if ($this->db->query($sql)) {
            $this->confirm();
        }
    }
}
