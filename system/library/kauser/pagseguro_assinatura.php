<?php

/**
 * Authorization Class, not any doc here so feel free to doc it bro.
 * pt-BR: Extremamente sensível, antes de mexere ofereça um belo vinho.
 */

class PagSeguroAssinatura
{
    public $reference;

    public $redirectURL;

    public $reviewURL;

    private $email;

    private $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function setEnvironment($env)
    {
        $this->env = $env;
    }

    public function setSenderName($name)
    {
        $this->senderName = $name;
    }

    public function setSenderAreaCode($code)
    {
        $this->senderAreaCode = $code;
    }

    public function setSenderPhone($phone)
    {
        $this->senderPhone = $phone;
    }

    public function setSenderEmail($email)
    {
        if ($this->env == 'sandbox') {
            $this->senderEmail = 'userps@sandbox.pagseguro.com.br';
        } else {
            $this->senderEmail = $email;
        }
    }

    public function setSenderAddressStreet($param)
    {
        $this->senderAddressStreet = $param;
    }

    public function setSenderAddressNumber($param)
    {
        $this->senderAddressNumber = $param;
    }

    public function setSenderAddressComplement($param)
    {
        $this->senderAddressComplement = $param;
    }

    public function setSenderAddressDistrict($param)
    {
        $this->senderAddressDistrict = $param;
    }

    public function setSenderAddressPostalCode($param)
    {
        $this->senderAddressPostalCode = $param;
    }

    public function setSenderAddressCity($param)
    {
        $this->senderAddressCity = $param;
    }

    public function setSenderAddressState($param)
    {
        $this->senderAddressState = $param;
    }

    public function setSenderAddressCountry($param)
    {
        $this->senderAddressCountry = $param;
    }

    public function setApprovalCharge($param)
    {
        $this->approvalCharge = $param;
    }

    public function setApprovalName($param)
    {
        $this->approvalName = $param;
    }

    public function setApprovalDetails($param)
    {
        $this->approvalDetails = $param;
    }

    public function setApprovalAmountPerPayment($param)
    {
        $this->approvalAmountPerPayment = $param;
    }

    public function setApprovalPeriod($param)
    {
        $this->approvalPeriod = $param;
    }

    public function setApprovalFinalDate($param)
    {
        $this->approvalFinalDate = $param;
    }

    public function setApprovalMaxTotalAmount($param)
    {
        $this->approvalMaxTotalAmount = $param;
    }

    public function setReference($ref)
    {
        $this->reference = $ref;
    }

    public function setRedirectURL($redir)
    {
        $this->redirectURL = $redir;
    }

    public function setReviewURL($review)
    {
        $this->reviewURL = $review;
    }

    public function formatXML()
    {

        $dom = new DOMDocument("1.0", "UTF-8");

        $dom->preserveWhiteSpace = false;

        $dom->formatOutput = true;

        $root                 = $dom->createElement("preApprovalRequest");
        $redirectURL          = $dom->createElement("redirectURL", $this->redirectURL);
        $reviewURL            = $dom->createElement("reviewURL", $this->reviewURL);
        $reference            = $dom->createElement("reference", $this->reference);
        $sender               = $dom->createElement('sender');
        $senderName           = $dom->createElement('name', $this->senderName);
        $senderEmail          = $dom->createElement('email', $this->senderEmail);
        $senderPhone          = $dom->createElement('phone');
        $senderAreaCode       = $dom->createElement('area', $this->senderAreaCode);
        $senderNumber         = $dom->createElement('phone', $this->senderPhone);
        $senderAddress        = $dom->createElement('address');
        $ad_street            = $dom->createElement('street', $this->senderAddressStreet);
        $ad_number            = $dom->createElement('number', $this->senderAddressNumber);
        $ad_complement        = $dom->createElement('complement', $this->senderAddressComplement);
        $ad_district          = $dom->createElement('district', $this->senderAddressDistrict);
        $ad_postalcode        = $dom->createElement('postalcode', $this->senderAddressPostalCode);
        $ad_city              = $dom->createElement('city', $this->senderAddressCity);
        $ad_state             = $dom->createElement('state', $this->senderAddressState);
        $ad_country           = $dom->createElement('country', $this->senderAddressCountry);
        $preapproval          = $dom->createElement('preApproval');
        $pre_charge           = $dom->createElement('charge', $this->approvalCharge);
        $pre_name             = $dom->createElement('name', $this->approvalName);
        $pre_details          = $dom->createElement('details', $this->approvalDetails);
        $pre_amountPerPayment = $dom->createElement('amountPerPayment', $this->approvalAmountPerPayment);
        $pre_period           = $dom->createElement('period', $this->approvalPeriod);
        $pre_finalDate        = $dom->createElement('finalDate', $this->approvalFinalDate);
        $pre_maxTotalAmount   = $dom->createElement('maxTotalAmount', $this->approvalMaxTotalAmount);

        $root->appendChild($redirectURL);
        $root->appendChild($reviewURL);
        $root->appendChild($reference);
        $root->appendChild($sender);
        $root->appendChild($preapproval);
        $sender->appendChild($senderName);
        $sender->appendChild($senderEmail);
        $sender->appendChild($senderPhone);
        $senderPhone->appendChild($senderAreaCode);
        $senderPhone->appendChild($senderNumber);
        $sender->appendChild($senderAddress);
        $senderAddress->appendChild($ad_street);
        $senderAddress->appendChild($ad_number);
        $senderAddress->appendChild($ad_complement);
        $senderAddress->appendChild($ad_district);
        $senderAddress->appendChild($ad_postalcode);
        $senderAddress->appendChild($ad_city);
        $senderAddress->appendChild($ad_state);
        $senderAddress->appendChild($ad_country);
        $preapproval->appendChild($pre_charge);
        $preapproval->appendChild($pre_name);
        $preapproval->appendChild($pre_details);
        $preapproval->appendChild($pre_amountPerPayment);
        $preapproval->appendChild($pre_period);
        $preapproval->appendChild($pre_finalDate);
        $preapproval->appendChild($pre_maxTotalAmount);
        $dom->appendChild($root);
        return $dom->saveXML();
    }

    public function XML2Array($parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = &$array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = &$node[];

            $node = $element->count() ? XML2Array($element) : trim($element);
        }

        return $array;
    }

    public function dump()
    {
        $xml = simplexml_load_string($this->formatXML());

        echo "<pre>";
        var_dump($xml);
        echo "</pre>";
    }
    public function formatURL()
    {
        if ($this->env == 'sandbox') {
            $this->url = "https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request?email={$this->email}&token={$this->token}";
        } else {
            $this->url = "https://ws.pagseguro.uol.com.br/v2/pre-approvals/request?email={$this->email}&token={$this->token}";
        }
        return $this->url;
    }

    public function registerOrder()
    {
        $ch = curl_init();

        $options = array(CURLOPT_URL => $this->formatURL(),
            CURLOPT_SSL_VERIFYHOST       => 0,
            CURLOPT_SSL_VERIFYPEER       => 0,
            CURLOPT_POST                 => true,
            CURLOPT_HTTPHEADER           => array('Content-Type: application/xml; charset=utf-8'),
            CURLOPT_POSTFIELDS           => $this->formatXML(),
            CURLOPT_RETURNTRANSFER       => true,
        );
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'rw+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        $result = curl_exec($ch);
        curl_close($ch);

        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);

        return simplexml_load_string($result);
    }
    public function location($xml)
    {

        if ($this->env == 'sandbox') {
            $url = "https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code=";
        } else {
            $url = "https://pagseguro.uol.com.br/v2/pre-approvals/request.html?code=";
        }
        return $url . $xml->code;
    }
}
