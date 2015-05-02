<?php

class ControllerPaymentPagseguroAssinatura extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('payment/pagseguro_assinatura');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript('view/javascript/slick.min.js');

        $this->document->addStyle('view/stylesheet/slick/slick.css');
        $this->document->addStyle('view/stylesheet/slick/slick-theme.css');

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('pagseguro_assinatura', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['button_save']   = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false,
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_payment'),
            'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: ',
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('payment/pagseguro_assinatura', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: ',
        );

        $this->load->model('localisation/geo_zone');
        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/order_status');
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $configs = array(
            'sort_order',
            'status',
            'order_status',
            'ambiente',
            'token_sandbox',
            'token_producao',
            'email',
            'geo_zone_id',
        );

        foreach ($configs as $config) {
            if (isset($this->request->post['pagseguro_assinatura_' . $config])) {
                $this->data['pagseguro_assinatura_' . $config] = $this->request->post['pagseguro_assinatura_' . $config];
            } else {
                $this->data['pagseguro_assinatura_' . $config] = $this->config->get('pagseguro_assinatura_' . $config);
            }
        }

        $this->data['token'] = $this->session->data['token'];

        $this->data['action'] = $this->url->link('payment/pagseguro_assinatura', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'payment/pagseguro_assinatura.tpl';

        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    public function stream()
    {
        $stream = file_get_contents('http://www.codemarket.com.br/index.php?route=common%2Fafiliados');
        header('Content-Type: application/json');
        $this->response->setOutput($stream);
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/pagseguro_assinatura')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
