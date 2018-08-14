<?php

require_once "src/main/Bex/Bex.php";
require_once "src/main/Bex/merchant/request/VposConfig.php";
require_once "src/main/Bex/merchant/request/InstallmentRequest.php";
require_once "src/main/Bex/merchant/response/InstallmentsResponse.php";
require_once "src/main/Bex/merchant/response/Installment.php";
require_once "src/main/Bex/merchant/response/BinAndInstallments.php";
require_once "src/main/Bex/merchant/response/PaymentResultResponse.php";

require_once "src/main/Bex/merchant/security/EncryptionUtil.php";
require_once "src/main/Bex/enums/Banks.php";
require_once "src/main/Bex/util/MoneyUtils.php";

require_once "src/main/Bex/merchant/request/NonceRequest.php";
require_once "src/main/Bex/merchant/response/nonce/MerchantNonceResponse.php";
require_once "src/main/Bex/merchant/service/MerchantService.php";
require_once "src/main/Bex/merchant/security/EncryptionUtil.php";

use Bex\merchant\request\NonceRequest;
use Bex\merchant\response\nonce\MerchantNonceResponse;
use Bex\merchant\service\MerchantService;
use Bex\merchant\request\VposConfig;
use Bex\merchant\request\InstallmentRequest;
use Bex\merchant\response\InstallmentsResponse;
use Bex\merchant\response\PaymentResultResponse;
use Bex\merchant\security\EncryptionUtil;
use Bex\enums\Banks;
use Bex\util\MoneyUtils;
use Bex\merchant\response\Installment;
use Bex\merchant\response\BinAndInstallments;

class BKMExpress
{

    public function initSale($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL, $total)
    {

        $environment = ($preProdMode)?'PREPROD':'PRODUCTION';
        $config = Bex\config\BexPayment::startBexPayment($environment, $merchantId, $merchantPrivateKey);
        $merchantService = new Bex\merchant\service\MerchantService($config);
        $merchantResponse = $merchantService->login();
        $ticketResponse = $merchantService->oneTimeTicketWithNonce($merchantResponse->getToken(), $total, $installmentsURL, $nonceURL);
        $baseUrl = $config->getBexApiConfiguration()->getBaseUrl();
        $baseJsUrl = $config->getBexApiConfiguration()->getBaseJs();
        $ticketShortId = $ticketResponse->getTicketShortId();
        $ticketPath = $ticketResponse->getTicketPath();
        $ticketToken = $ticketResponse->getTicketToken();

        return [
            'baseUrl'=>$baseUrl,
            'baseJsUrl'=>$baseJsUrl,
            'ticketShortId'=>$ticketShortId,
            'ticketPath'=>$ticketPath,
            'ticketToken'=>$ticketToken,
        ];
    }

    public function getBankList()
    {
        $bankList = [
            Banks::AKBANK => [
                'name'=>'AKBANK',
                'params'=>[
                    'vposUserId' => ['title'=>'Vpos User Id', 'value'=>''],
                    'vposPassword' => ['title'=>'Vpos Password', 'value'=>''],
                    'clientId' => ['title'=>'Client Id', 'value'=>''],
                    'storeKey' => ['title'=>'Store Key', 'value'=>''],
                    'serviceUrl' => ['title'=>'Service Url', 'value'=>''],
                ],
                'installments'=> []
            ],
            Banks::GARANTI => [
                'name'=>'GARANTI',
                'params'=>[
                    'vposUserId' => ['title'=>'Vpos User Id', 'value'=>''],
                    'vposPassword' => ['title'=>'Vpos Password', 'value'=>''],
                    'terminalProvuserId' => ['title'=>'Terminal Prov User Id', 'value'=>''],
                    'terminalMerchantId' => ['title'=>'Terminal Merchant Id', 'value'=>''],
                    'storeKey' => ['title'=>'Store Key', 'value'=>''],
                    'terminalId' => ['title'=>'Terminal Id', 'value'=>''],
                    'serviceUrl' => ['title'=>'Service Url', 'value'=>''],
                ],
                'installments'=> []
            ],
            Banks::TEBBANK => [
                'name'=>'TEBBANK',
                'params'=>[
                    'vposUserId' => ['title'=>'Vpos User Id', 'value'=>''],
                    'vposPassword' => ['title'=>'Vpos Password', 'value'=>''],
                    'clientId' => ['title'=>'Client Id', 'value'=>''],
                    'storeKey' => ['title'=>'Store Key', 'value'=>''],
                    'serviceUrl' => ['title'=>'Service Url', 'value'=>''],
                ],
                'installments'=> []
            ],
        ];

        return $bankList;

//        return [
//            //Banks::ALBARAKA => 'ALBARAKA',
//            Banks::AKBANK => 'AKBANK',
//            //Banks::DENIZBANK => 'DENIZBANK',
//            //Banks::FINANSBANK => 'FINANSBANK',
//            Banks::GARANTI => 'GARANTI',
//            //Banks::HALKBANK => 'HALKBANK',
//            //Banks::HSBC => 'HSBC',
//            //Banks::ISBANK => 'ISBANK',
//            //Banks::ING => 'ING',
//            //Banks::KUVEYTTURK => 'KUVEYTTURK',
//            //Banks::ODEABANK => 'ODEABANK',
//            //Banks::SEKERBANK => 'SEKERBANK',
//            Banks::TEBBANK => 'TEBBANK',
//            //Banks::TFKB => 'TFKB',
//            //Banks::VAKIFBANK => 'VAKIFBANK',
//            //Banks::YKB => 'YKB',
//            //Banks::ZIRAATBANK => 'ZIRAATBANK',
//        ];

    }

    public function installments($installmentsArray, $bankConfigArray, $data){
        header('Content-type: application/json');
        if(!empty($data)){
            $InstallmentRequest = new InstallmentRequest(
                $data['bin'],
                $data['totalAmount'],
                $data['ticketId'],
                $data['signature']
            );

            $process = new RequestMerchInfoService($installmentsArray, $bankConfigArray);
            $result = $process->getInstallmentResponse($InstallmentRequest);
            echo json_encode(['data'=>$result, 'status'=>'ok', 'error'=>'']);
        }else{
            echo json_encode(['data'=>[], 'status'=>'fail', 'error'=>'No Data']);
        }
    }

    public function nonce($merchantPrivateKey, $preProdMode, $merchantId, $data, $orderTotal, $orderStatus){
        $environment = ($preProdMode)?'PREPROD':'PRODUCTION';
        header('Content-type: application/json');

        if (!empty($data)) {
            ob_start();
            // Send your response.
            echo json_encode(array("result" => "ok", "data" => "ok")) ;
            // Get the size of the output.
            $size = ob_get_length();        // Disable compression (in case content length is compressed).
            header("Content-Encoding: none");
            header($_SERVER["SERVER_PROTOCOL"] . " 202 Accepted");
            header("Status: 202 Accepted");
            // Set the content length of the response.
            header("Content-Length: {$size}");
            // Close the connection.
            header("Connection: close");
            ignore_user_abort(true);
            set_time_limit(0);        // Flush all output.
            ob_end_flush();
            ob_flush();
            flush();
            session_write_close();

            //fastcgi_finish_request();


            $data["reply"]['deliveryAddress'] = null;
            $data["reply"]['billingAddress'] = null;
            $data["reply"]["tcknMatch"] = True;
            $data["reply"]["msisdnMatch"] = True;

            $nonceRequest = new NonceRequest(
                $data["id"],
                $data["path"],
                $data["issuer"],
                $data["approver"],
                $data["token"],
                $data["signature"],
                $data["reply"],
                $data["reply"]["hash"],
                $data["reply"]["tcknMatch"],
                $data["reply"]["msisdnMatch"]
            );

            $config = Bex\config\BexPayment::startBexPayment($environment, $merchantId, $merchantPrivateKey);
            $merchantNonceResponse = new MerchantNonceResponse();
            $merchantService = new MerchantService($config);
            $merchantLoginResponse = $merchantService->login();

            if($nonceRequest->getTotalAmount() != $orderTotal OR $orderStatus == False){
                $merchantNonceResponse->setResult(false);
                $merchantNonceResponse->setNonce($nonceRequest->getToken());
                $merchantNonceResponse->setId($nonceRequest->getPath());
                $merchantNonceResponse->setMessage("Wrong Order!");
                $merchantService->sendNonceResponse(
                    $merchantNonceResponse,
                    $merchantLoginResponse->getPath(),
                    $nonceRequest->getPath(), $merchantLoginResponse->getConnectionToken(),
                    $nonceRequest->getToken()
                );
            }

            if(EncryptionUtil::verifyBexSign($nonceRequest->getTicketId(), $nonceRequest->getSignature())){
                $merchantNonceResponse->setResult(true);
                $merchantNonceResponse->setNonce($nonceRequest->getToken());
                $merchantNonceResponse->setId($nonceRequest->getPath());

                return $merchantService->sendNonceResponse(
                    $merchantNonceResponse,
                    $merchantLoginResponse->getPath(),
                    $nonceRequest->getPath(),
                    $merchantLoginResponse->getConnectionToken(),
                    $nonceRequest->getToken()
                );
            } else {
                $merchantNonceResponse->setResult(false);
                $merchantNonceResponse->setNonce($nonceRequest->getToken());
                $merchantNonceResponse->setId($nonceRequest->getPath());
                $merchantNonceResponse->setMessage("Signature verification failed");
                $merchantService->sendNonceResponse(
                    $merchantNonceResponse,
                    $merchantLoginResponse->getPath(),
                    $nonceRequest->getPath(), $merchantLoginResponse->getConnectionToken(),
                    $nonceRequest->getToken()
                );
            }
            return $merchantNonceResponse;
        }else{
            echo json_encode(array("result" => "fail", "data" => "fail")) ;
            return false;
        }
    }

    public function refresh($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL, $total){
        $environment = ($preProdMode)?'PREPROD':'PRODUCTION';
        $config = Bex\config\BexPayment::startBexPayment($environment, $merchantId, $merchantPrivateKey);
        $merchantService = new Bex\merchant\service\MerchantService($config);
        $merchantResponse = $merchantService->login();
        $ticketResponse = $merchantService->oneTimeTicketWithNonce($merchantResponse->getToken(), $total, $installmentsURL, $nonceURL);

        $ticketRefresh = new \Bex\merchant\response\TicketRefresh(
            $ticketResponse->getTicketShortId(),
            $ticketResponse->getTicketPath(),
            $ticketResponse->getTicketToken()
        );

        $ticketId = $ticketRefresh->getId();
        $ticketPath = $ticketRefresh->getPath();
        $ticketToken = $ticketRefresh->getToken();
        exit(json_encode(["id"=>$ticketId, "path"=>$ticketPath, "token"=>$ticketToken]));
    }

    public function result($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL, $total){
        $environment = ($preProdMode)?'PREPROD':'PRODUCTION';
        $config = Bex\config\BexPayment::startBexPayment($environment, $merchantId, $merchantPrivateKey);
        $merchantService = new Bex\merchant\service\MerchantService($config);
        $merchantResponse = $merchantService->login();
        $ticketResponse = $merchantService->oneTimeTicketWithNonce($merchantResponse->getToken(), $total, $installmentsURL, $nonceURL);

        $ticketResponse = new PaymentResultResponse(
            $ticketResponse->getTicketShortId(),
            $ticketResponse->getTicketPath(),
            $ticketResponse->getTicketToken()
        );

        return $ticketResponse->getPaymentPurchased();
    }
}

class RequestMerchInfoService
{
    public $installmentsArray;
    public $bankConfigArray;

    public function __construct($installmentsArray, $bankConfigArray)
    {
        $this->installmentsArray = $installmentsArray;
        $this->bankConfigArray = $bankConfigArray;
    }

    public function getInstallmentResponse(InstallmentRequest $installmentRequest){

        $installmentResponse = new InstallmentsResponse();
        if(!EncryptionUtil::verifyBexSign( $installmentRequest->getTicketId() , $installmentRequest->getSignature())){
            $installmentResponse->setError("Signature verification failed");
            $installmentResponse->setStatus("fail");
            return $installmentResponse;
        }
        return $this->initInstallment($installmentRequest,$installmentResponse);
    }

    public function  initInstallment(InstallmentRequest $installmentRequest , InstallmentsResponse $installmentResponse){
        if(!isset($installmentRequest)){
            $installmentResponse->setError("Request Body can not be null !");
            return $installmentResponse;
        }else if (empty($installmentRequest->getBinNo()) || empty($installmentRequest->getTotalAmount()) || empty($installmentRequest->getTicketId())){
            $installmentResponse->setError("Request Body variables can not be null !");
            return $installmentResponse;
        }else if (!EncryptionUtil::verifyBexSign($installmentRequest->getTicketId(),$installmentRequest->getSignature())){
            $installmentResponse->setError("Signature verification failed");
            return $installmentResponse;
        }
        $installments = [];
        $binAndBank = $installmentRequest->getBinNo()[0] ;

        $explodedArr = explode("@",$binAndBank);
        foreach ($this->installmentsArray[(string)$explodedArr[1]] as $i => $instActive){
            if($instActive == False) continue;
            $instalmentAmount = MoneyUtils::toFloat($installmentRequest->getTotalAmount()) / floatval($i);
            $instalmentAmount = MoneyUtils::formatTurkishLira($instalmentAmount);
            $vposConfig = $this->prepareVposConfig((string)$explodedArr[1]);
            $installment = new Installment((string)$i,$instalmentAmount,(string)$i,$installmentRequest->getTotalAmount(), $vposConfig);
            $out =  array(
                'numberOfInstallment' => $installment->getNumberOfInstallment() ,
                'installmentAmount' => $installment->getInstallmentAmount() ,
                'totalAmount' => $installment->getTotalAmount() ,
                'vposConfig' => $vposConfig
            );
            array_push($installments,$out);
        }
        $binAndInstallments = new BinAndInstallments();
        $installmentResponse->setInstallments($installments);
        $installmentResponse->setStatus("ok");
        $installmentResponse->setBin($explodedArr[0]);
        $returnArray = array();
        $returnArray[$installmentResponse->getBin()] = $installmentResponse->getInstallments();
        $binAndInstallments->setInstallments($returnArray);
        return $binAndInstallments;
    }

    public function prepareVposConfig($bankCode){
        $vposConfig = new VposConfig();

        if (Banks::AKBANK == $bankCode) {
            $vposConfig->setVposUserId($this->bankConfigArray[$bankCode]['params']['vposUserId']['value']);
            $vposConfig->setVposPassword($this->bankConfigArray[$bankCode]['params']['vposPassword']['value']);
            $vposConfig->addExtra("ClientId", $this->bankConfigArray[$bankCode]['params']['clientId']['value']);
            $vposConfig->addExtra("storekey", $this->bankConfigArray[$bankCode]['params']['storeKey']['value']);
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl($this->bankConfigArray[$bankCode]['params']['serviceUrl']['value']);
            $vposConfig->setPreAuth(false);
        } else if(Banks::TEBBANK == $bankCode) {
            $vposConfig->setVposUserId($this->bankConfigArray[$bankCode]['params']['vposUserId']['value']);
            $vposConfig->setVposPassword($this->bankConfigArray[$bankCode]['params']['vposPassword']['value']);
            $vposConfig->addExtra("ClientId", $this->bankConfigArray[$bankCode]['params']['clientId']['value']);
            $vposConfig->addExtra("storekey", $this->bankConfigArray[$bankCode]['params']['storeKey']['value']);
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl($this->bankConfigArray[$bankCode]['params']['serviceUrl']['value']);
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setPreAuth(false);
        } else if(Banks::GARANTI == $bankCode) {
            $vposConfig->setVposUserId($this->bankConfigArray[$bankCode]['params']['vposUserId']['value']);
            $vposConfig->setVposPassword($this->bankConfigArray[$bankCode]['params']['vposPassword']['value']);
            $vposConfig->addExtra("terminalprovuserid", $this->bankConfigArray[$bankCode]['params']['terminalProvuserId']['value']);
            $vposConfig->addExtra("terminalmerchantid", $this->bankConfigArray[$bankCode]['params']['terminalMerchantId']['value']);
            $vposConfig->addExtra("storekey", $this->bankConfigArray[$bankCode]['params']['storeKey']['value']);
            $vposConfig->addExtra("terminalid", $this->bankConfigArray[$bankCode]['params']['terminalId']['value']);
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl($this->bankConfigArray[$bankCode]['params']['serviceUrl']['value']);
        } else if(Banks::VAKIFBANK == $bankCode) {
            //.......
        }

        $vp = [
            'vposUserId' => $vposConfig->getVposUserId(),
            'vposPassword' => $vposConfig->getVposPassword(),
            'extra' => $vposConfig->getExtra(),
            'bankIndicator' => $vposConfig->getBankIndicator(),
            'serviceUrl' => $vposConfig->getServiceUrl(),
            'preAuth' => $vposConfig->getPreAuth(),
        ];

        return EncryptionUtil::encryptWithBex(json_encode($vp));
    }
}