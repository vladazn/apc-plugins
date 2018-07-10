<?php
namespace ApcCleverreach\Services;

class ApiService {

	private $db = null;
	private $pluginDir = null;
	private $config = null;
	private $snippetManager = null;


    public function __construct($pluginDir) {
        $this->pluginDir = $pluginDir;
		$this->setConfig();
		$this->snippetManager = Shopware()->Snippets();
	}

    public function getApi(){
		$tokenData = $this->getToken();
        require_once($this->pluginDir.'/Resources/api/rest_client.php');
        $api = new \rest('https://rest.cleverreach.com/v3');
		$api->setAuthMode($tokenData['token_type'],$tokenData['access_token']);

        return $api;
    }

	public function getToken(){
		$clientid     = $this->config['clientId'];
		$clientsecret = $this->config['clientSecret'];

		// The official CleverReach URL, no need to change this.
		$token_url = "https://rest.cleverreach.com/oauth/token.php";

		// This must be the same as the previous redirect uri
		$fields["grant_type"] = "client_credentials";

		// We use curl to make the request
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, $token_url);
		curl_setopt($curl,CURLOPT_USERPWD, $clientid . ":" . $clientsecret);
		curl_setopt($curl,CURLOPT_POSTFIELDS, array("grant_type" => "client_credentials"));
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		curl_close ($curl);

		// The final $result contains the access_token and some other information besides.
		// For you to see it, we dump it out here.

		return json_decode($result, true);

	}

	public function setConfig(){
		$sConfig = Shopware()->Config();
		$this->config = [
			'clientId' => $sConfig->get('apc_clevverreach_clientid'),
			'clientSecret' => $sConfig->get('apc_clevverreach_clientsecret'),
			'source' => $sConfig->get('apc_clevverreach_source'),
			'groupId' => $sConfig->get('apc_clevverreach_group'),
			'formId' => $sConfig->get('apc_clevverreach_form'),
		];
	}


	public function newsletterEmail($email){
		//
		$validation = $this->validateNewsletter($email);
		if(is_array($validation)){
			return $validation;
		}

		$rest = $this->getApi();
		$new_user = array(
			"email"      => $email,
			"registered" => time(),  //current date
			"activated"  => 0,       //NOT active, will be set by DOI
			"source"     => $this->config['source'],
		);
		$doidata = array(
			"user_ip"    => $_SERVER["REMOTE_ADDR"],
			"referer"    => $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],
			"user_agent" => $_SERVER["HTTP_USER_AGENT"]
		);
		try{
			$rest->post("/groups/".$this->config['groupId']."/receivers", $new_user);
			$result = $rest->post("/forms/".$this->config['formId']."/send/activate", array(
				"email"   => $new_user['email'],
				"doidata" => $doidata
			));
			return [
				   'code' => 3,
				   'message' => $this->snippetManager->getNamespace('frontend/account/internalMessages')
					   ->get('NewsletterSuccess', 'Thank you for receiving our newsletter'),
			   ];
		}catch(\Exception $e){
			return [
                    'code' => 10,
                    'message' => $this->snippetManager->getNamespace('frontend/account/internalMessages')
                        ->get('UnknownError', 'Unknown error'),
                ];
		}


	}

	public function validateNewsletter($email){
		if (empty($email)) {
            return [
                'code' => 6,
                'message' => $this->snippetManager->getNamespace('frontend/account/internalMessages')
                    ->get('NewsletterFailureMail', 'Enter eMail address'),
            ];
        }

		if (!Shopware()->Container()->get('validator.email')->isValid($email)) {
            return [
                'code' => 1,
                'message' => $this->snippetManager->getNamespace('frontend/account/internalMessages')
                    ->get('NewsletterFailureInvalid', 'Enter valid eMail address'),
            ];
        }

		return 'success';
	}


}
