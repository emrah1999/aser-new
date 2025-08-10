<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AzerCardService
{
//    private $baseUrl = "https://testmpi.3dsecure.az/cgi-bin/";
    private $baseUrl = "https://mpi.3dsecure.az/cgi-bin/";
//    private $callBackUrl="https://front.ailemiz.az/az/account/special-order
    private $callBackUrl="https://asercargo.az/az/account/special-order";
    private $merchName="Asercago.az";
//    private $merchUrl="http://front.ailemiz.az";

    private $merchUrl="https://asercargo.az";

//    private $terminal="17204514";
    private $terminal="17205238";
    private $country="AZ";
    private $timezone="Asia/Baku";
    protected  $privateKey;
    protected  $publicKey;

    public function __construct()
    {
//        $this->privateKey = file_get_contents(storage_path('keys/azeri-card-private.pem'));
//        $this->publicKey = file_get_contents(storage_path('keys/azeri-card-public.pem'));
        $this->privateKey = file_get_contents('/var/www/sites/certificates/azeri-card-private.pem');
        $this->publicKey = file_get_contents('/var/www/sites/certificates/azeri-card-public.pem');
    }

    public function generateMacSource(array $data, array $fields): string
    {
        $mac = '';
        foreach ($fields as $field) {
            if (!isset($data[$field])) {
                throw new \Exception("Missing field: {$field}");
            }

            $value = (string)$data[$field];
            $mac .= strlen($value) . $value;
        }
        Log::channel('azeri_card')->info("SOuirce kode".$mac);

        return $mac;
    }

    public function generatePsign(string $macSource): string
    {
        openssl_sign($macSource, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
        return bin2hex($signature);
    }

    public function verifyCallbackSignature(array $data): bool
    {
        $pSign = $data['P_SIGN'] ?? null;

        if (!$pSign) {
            Log::channel('azeri_card')->info('[Azericard] Callback P_SIGN tapılmadı.');
            return false;
        }

        $toSign =
            strlen($data['AMOUNT']) . $data['AMOUNT']
            . strlen($data['TERMINAL']) . $data['TERMINAL']
            . (empty($data['APPROVAL']) ? '-' : strlen($data['APPROVAL']) . $data['APPROVAL'])
            . (empty($data['RRN']) ? '-' : strlen($data['RRN']) . $data['RRN'])
            . (empty($data['INT_REF']) ? '-' : strlen($data['INT_REF']) . $data['INT_REF']);

        $hashedData = hash('sha256', $toSign, true);

        $bankPublicKey = file_get_contents(storage_path('keys/azeri-card-public.pem'));

        $publicKeyResource = openssl_pkey_get_public($bankPublicKey);

        if (!$publicKeyResource) {
            Log::channel('azeri_card')->info('[Azericard] Public açar yüklənmədi.');
            return false;
        }

        $pSignBinary = hex2bin($pSign);

        if ($pSignBinary === false) {
            Log::channel('azeri_card')->info('[Azericard] P_SIGN hex çevrilməsində xəta.');
            return false;
        }

        $verified = openssl_verify($hashedData, $pSignBinary, $publicKeyResource, OPENSSL_ALGO_SHA256);

        if ($verified === 1) {
            Log::channel('azeri_card')->info('[Azericard] ✅ Callback imzası doğrudur.');
            return true;
        } elseif ($verified === 0) {
            Log::channel('azeri_card')->info('[Azericard] ❌ Callback imzası səhvdir.');
            return false;
        } else {
            Log::channel('azeri_card')->info('[Azericard] ⚠️ OpenSSL xətası: ' . openssl_error_string());
            return false;
        }
    }


    public function buildPaymentData(array $order): array
    {
        $nonce = bin2hex(random_bytes(8));

        $data = [
            'AMOUNT'     => $order['amount'],
            'CURRENCY'   => $order['currency'],
            'ORDER'      => $order['id'],
            'DESC'       => $order['description'] ?? 'Order Payment',
            'MERCH_NAME' => $this->merchName,
            'MERCH_URL'  => $this->merchUrl,
            'MERCHANT'   => $order['merchant_id'],
            'TERMINAL'   => $this->terminal,
            'EMAIL'      => $order['email'],
            'TRTYPE'     => '1',
            'COUNTRY'    => $this->country,
            'MERCH_GMT'  => $this->timezone,
            'TIMESTAMP'  => now('UTC')->format('YmdHis'),
            'NONCE'      => $nonce,
            'BACKREF'    => $this->callBackUrl,
            'LANG'       => $this->country,
            'NAME'       => $order['customer_name'],
            'M_INFO'     => base64_encode(json_encode([
                "browserScreenHeight" => "1920",
                "browserScreenWidth"  => "1080",
                "browserTZ"           => "0",
                "mobilePhone"         => [
                    "cc"         => "994",
                    "subscriber" => $order['phone'],
                ]
            ])),
        ];

        $macFields = ['AMOUNT', 'CURRENCY', 'TERMINAL', 'TRTYPE', 'TIMESTAMP', 'NONCE', 'MERCH_URL'];
        $macSource = $this->generateMacSource($data, $macFields);
        $data['P_SIGN'] = $this->generatePsign($macSource);

        return $data;
    }
    public function checkTrType($array){
        $nonce = bin2hex(random_bytes(8));
        $data = [
            'AMOUNT'     => $array['AMOUNT'],
            'CURRENCY'   => $array['CURRENCY'],
            'TERMINAL'   => $this->terminal,
            'TRTYPE'     => '22',
            'ORDER'      => $array['ORDER'],
            'RRN'        => $array['RRN'],
            'INT_REF'    => $array['INT_REF'],
            'TIMESTAMP'  => $array['TIMESTAMP'],
            'NONCE'      => $array['NONCE'],
        ];

        $macFields = ['AMOUNT', 'CURRENCY', 'TERMINAL', 'TRTYPE', 'ORDER', 'RRN', 'INT_REF'];
        $macSource = $this->generateMacSource($data, $macFields);
        $data['P_SIGN'] = $this->generatePsign($macSource);

        return $data;
    }

    public function confirmPayment(array $fields): array
    {
        $macFields = ['ORDER', 'AMOUNT', 'CURRENCY', 'TERMINAL', 'TRTYPE', 'TIMESTAMP', 'NONCE'];
        $macSource = $this->generateMacSource($fields, $macFields);
        $fields['P_SIGN'] = $this->generatePsign($macSource);

        return Http::asForm()->post($this->baseUrl.'cgi_link', $fields)->json();
    }

}