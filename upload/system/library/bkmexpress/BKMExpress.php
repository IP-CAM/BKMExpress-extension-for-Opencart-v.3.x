<?php

class BKMExpress
{

    public function initSale($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL)
    {
        require_once "src/main/Bex/Bex.php";
        $environment = ($preProdMode)?'PREPROD':'PRODUCTION';
        $config = Bex\config\BexPayment::startBexPayment($environment, $merchantId, $merchantPrivateKey);
        $merchantService = new Bex\merchant\service\MerchantService($config);
        $merchantResponse = $merchantService->login();
        $ticketResponse = $merchantService->oneTimeTicketWithNonce($merchantResponse->getToken(), "11,12", $installmentsURL, $nonceURL);
        $baseUrl = $config->getBexApiConfiguration()->getBaseUrl();
        $ticketShortId = $ticketResponse->getTicketShortId();
        $ticketPath = $ticketResponse->getTicketPath();
        $ticketToken = $ticketResponse->getTicketToken();

        return [
            'baseUrl'=>$baseUrl,
            'ticketShortId'=>$ticketShortId,
            'ticketPath'=>$ticketPath,
            'ticketToken'=>$ticketToken,
        ];


    }

    public function test()
    {
        echo '<pre>';
        var_dump('test lib');
        echo '</pre>';
        die;
    }

}