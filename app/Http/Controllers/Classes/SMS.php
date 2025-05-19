<?php


namespace App\Http\Controllers\Classes;


class SMS
{
    public function sendBulkSms($message, $users, $control_id) {
        if (count($users) == 0) {
            return [false];
        }

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<request>';
        $xml .=     '<head>';
        $xml .=         '<operation>submit</operation>';
        $xml .=         '<login>asercargo</login>';
        //$xml .=         '<password>kl4Fz31S</password>';
        //$xml .=         '<password>Hgt2yR1n</password>';
	    //$xml .=         '<password>gRe3@2Cs</password>';
        $xml .=         '<password>!A%Wz)flglUx</password>';
        $xml .=         '<controlid>' . $control_id . '</controlid>';
        $xml .=         '<title>Aser Cargo</title>';
        $xml .=         '<bulkmessage>' . $message . '</bulkmessage>';
        //$xml .=         '<scheduled>' . date('Y-m-d H:i:s', (strtotime('+ 1 minute'))) . '</scheduled>';
        $xml .=         '<scheduled>' . date('Y-m-d H:i:s', (strtotime('+5 seconds'))) . '</scheduled>';
        $xml .=         '<isbulk>true</isbulk>';
        $xml .=      '</head>';

        foreach ($users as $user) {
            $xml .=      '<body>';
            $xml .=         '<msisdn>'.  $user . '</msisdn>';
            $xml .=      '</body>';
        }

        $xml .= '</request>';

        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($xml),
            "Connection: close",
        );

        return $this->sendCurlRequest('http://www.sendsms.az/smxml/api', $xml, $headers);
    }

    public function sendCurlRequest($URL, $data, $headers) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result=curl_exec($ch);

            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
            curl_close ($ch);

//            dd([
//                'data' => $data,
//                'status_code' => $headers
//            ]);

            //$this->writeToLog('sendBulkSms', serialize($data), serialize($result));

            return [true, $result];
        } catch (\Exception $exception) {
            return [false];
        }
    }
}
