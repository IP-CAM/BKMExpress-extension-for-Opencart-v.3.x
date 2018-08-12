<?php

require_once "src/main/Bex/Bex.php";
require_once "src/main/Bex/merchant/request/VposConfig.php";
require_once "src/main/Bex/merchant/request/InstallmentRequest.php";
require_once "src/main/Bex/merchant/response/InstallmentsResponse.php";
require_once "src/main/Bex/merchant/response/Installment.php";
require_once "src/main/Bex/merchant/response/BinAndInstallments.php";

require_once "src/main/Bex/merchant/security/EncryptionUtil.php";
require_once "src/main/Bex/enums/Banks.php";
require_once "src/main/Bex/util/MoneyUtils.php";

use Bex\merchant\request\VposConfig;
use Bex\merchant\request\InstallmentRequest;
use Bex\merchant\response\InstallmentsResponse;
use Bex\merchant\security\EncryptionUtil;
use Bex\enums\Banks;
use Bex\util\MoneyUtils;
use Bex\merchant\response\Installment;
use Bex\merchant\response\BinAndInstallments;

class BKMExpress
{

    public function initSale($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL)
    {

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

    public function installments($installmentsArray, $bankConfigArray){
        header('Content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), True);
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
        }
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
        $installments = array();
        $binAndBank = $installmentRequest->getBinNo()[0] ;

        $explodedArr = explode("@",$binAndBank);
        foreach ($this->installmentsArray[$explodedArr[1]] as $i => $instActive){
            if($instActive == False) continue;
            $instalmentAmount = MoneyUtils::toFloat($installmentRequest->getTotalAmount()) / floatval($i);
            $instalmentAmount = MoneyUtils::formatTurkishLira($instalmentAmount);
            $vposConfig = $this->prepareVposConfig($explodedArr[1]);
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
            $vposConfig->setVposUserId("akapi");
            $vposConfig->setVposPassword("TEST1234");
            $vposConfig->addExtra("ClientId", "100111222");
            $vposConfig->addExtra("storekey", "TEST1234");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setServiceUrl("http://srvirt01:7200/akbank");
            $vposConfig->setPreAuth(false);
        } else if(Banks::TEBBANK == $bankCode) {
            $vposConfig->setVposUserId("bkmapi");
            $vposConfig->setVposPassword("KUTU8520");
            $vposConfig->addExtra("ClientId", "401562930");
            $vposConfig->addExtra("storekey", "KUTU8520");
            $vposConfig->setServiceUrl("http://srvirt01:7200/teb");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setPreAuth(false);
        } else if(Banks::GARANTI == $bankCode) {
            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setPreAuth(false);
        } else if(Banks::VAKIFBANK == $bankCode) {
            //.......
        }else{
            $vposConfig->setVposUserId("600218");
            $vposConfig->setVposPassword("123qweASD");
            $vposConfig->addExtra("terminalprovuserid", "PROVAUT");
            $vposConfig->addExtra("terminalmerchantid", "7000679");
            $vposConfig->addExtra("storekey", "12345678");
            $vposConfig->addExtra("terminalid", "30690168");
            $vposConfig->setServiceUrl("http://srvirt01:7200/VPServlet");
            $vposConfig->setBankIndicator($bankCode);
            $vposConfig->setPreAuth(false);
        }

        $vposConfig = [
            'vposUserId' => '600218',
            'vposPassword' => '123qweASD',
            'extra' => [
                'terminalprovuserid'=>'PROVAUT',
                'terminalmerchantid'=>'7000679',
                'storekey'=>'12345678',
                'terminalid'=>'30690168',
            ],
            'bankIndicator' => $bankCode,
            'serviceUrl' => 'http://srvirt01:7200/VPServlet',
            'preAuth' => false,
        ];

        return EncryptionUtil::encryptWithBex($vposConfig);
    }
}