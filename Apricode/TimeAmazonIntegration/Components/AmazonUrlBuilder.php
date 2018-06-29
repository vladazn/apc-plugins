<?php

namespace TimeAmazonIntegration\Components;

class AmazonUrlBuilder {
    private $secretKey = NULL;
    private $keyId = NULL;
    private $associateTag = NULL;
    private $amazonEndpoint = NULL;
	private $endpoint = 'onca/xml';

	private function throwIfNull($parameterValue, $parameterName) {
		if ($parameterValue == NULL) {
			throw new \Exception($parameterName . ' should be defined');
		}
	}
    public function __construct($keyId, $secretKey, $end_point, $locale = 'us') {
		$this->throwIfNull($keyId, 'Amazon key ID');
		$this->throwIfNull($secretKey, 'Amazon secret key');
        $this->secretKey = $secretKey;
        $this->endpoint = $end_point;
        $this->keyId = $keyId;
    }

	private function CreateUnsignedAmazonUrl($buildParams) {
        $request = $this->endpoint . '?' .http_build_query($buildParams);
		return($request);
	}
	private function createSignature($signatureString) {
        return urlencode(
			base64_encode(
				hash_hmac(
					'sha256',
					$signatureString,
                    $this->secretKey,
					true
				)
			)
		);
	}
	/**
	  * This function will take an existing Amazon request and change it so that it will be usable
	  * with the new authentication.
	  *
	  * @param string $request - your existing request URI
	  * @param string $version - (optional) the version of the service you are using
	  *
	  * @link http://www.ilovebonnie.net/2009/07/27/amazon-aws-api-rest-authentication-for-php-5/
	  */
	private function CreateSignedAwsRequest($request, $version = '2013-09-01') {
	    // Get a nice array of elements to work with
	    $uri_elements = parse_url($request);
        $uri_elements['path'] .= '/2013-09-01';
	    // Grab our request elements
	    $request = $uri_elements['query'];
	    // Throw them into an array
        parse_str($request, $parameters);
        $marketplaces = count($parameters)-8;
        for($i = 1; $i<=$marketplaces; $i++){
            // Add the new required paramters
            $parameters["MarketplaceId.Id.".$i] = $parameters["MarketplaceId_Id_".$i];
            unset($parameters["MarketplaceId_Id_".$i]);
        }
        //date_default_timezone_set ("America/Los_Angeles");
	    $parameters['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
	    //$parameters['Timestamp'] = "2018-06-09T20:48:40Z";
	    $parameters['Version'] = $version;
	    // The new authentication requirements need the keys to be sorted
	    ksort($parameters);
	    // Create our new request
	    foreach ($parameters as $parameter => $value) {
	        // We need to be sure we properly encode the value of our parameter
            $parameter = str_replace("%7E", "~", rawurlencode($parameter));
	        $value = str_replace("%7E", "~", rawurlencode($value));
	        $requestArray[] = $parameter . '=' . $value;
	    }

	    // Put our & symbol at the beginning of each of our request variables and put it in a string
	    $requestParameters = implode('&', $requestArray);
	    // Create our signature string

        $signatureString = "GET\n{$uri_elements['host']}\n{$uri_elements['path']}\n{$requestParameters}";

        $signature = $this->createSignature($signatureString);
	    // Return our new request
		$newUrl = "https://{$uri_elements['host']}{$uri_elements['path']}?{$requestParameters}&Signature={$signature}";
	    return $newUrl;
	}
    public function generate($params,$version) {
        //es buildery yndex standartner kan eli dranov sarqaca vor url sarqi vor get anes , signature ev ayln, menak es mi pay chem arel
        //et pars url y ketery poxum _ gceri
        //stex et responsy xml a galis eli, ydex mi komponentner el ka vor dzevapoxuma , es konkret arrayinnem grel, arrayova eli patasxany galis
        $unsignedRequest = $this->CreateUnsignedAmazonUrl($params);
		return $this->CreateSignedAwsRequest($unsignedRequest,$version);
    }
}
?>
