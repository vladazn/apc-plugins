<?php
namespace TimeAmazonIntegration\Components;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;
use TimeAmazonIntegration\Components\AmazonUrlBuilder;
use TimeAmazonIntegration\Components\Transformers\DataTransformerFactory;
use TimeAmazonIntegration\Components\CurlHttpRequest;


class Orders {

    private $container;
    private $urlBuilder = NULL;
	private $dataTransformer = NULL;
    private $mErrors = array();
    private $aws_key = NULL;
    private $secret_key = NULL;
    private $end_point = "https://mws-eu.amazonservices.com/Orders";

    public function __construct($aws_key, $secret_key, $endpoint) {
        $this->aws_key = $aws_key;
        $this->secret_key = $secret_key;
        $this->urlBuilder = new AmazonUrlBuilder($this->aws_key, $this->secret_key, $endpoint.'/Orders');
        $this->dataTransformer = DataTransformerFactory::create('array');
    }

    public function getOrders($buildParams){
      return $this->MakeAndParseRequest($buildParams);
    }

	public function GetErrors() {
		return $this->mErrors;
	}
	private function AddError($error) {
		array_push($this->mErrors, $error);
	}

    //es et componentna vorov getes anum - es inch amsativa?
    // et documentaciayum ka , amen mi request ira versian uni, senc amsatvova, de konkret orderi hamar es amenaverjinna
	private function MakeAndParseRequest($params) {
            $signedUrl = $this->urlBuilder->generate($params,'2013-09-01');
            try {
                $request = new CurlHttpRequest();
                $response = $request->execute($signedUrl);
                $parsedXml = simplexml_load_string($response);
                if ($parsedXml === false) {
                    return false;
                }
                $data = $this->dataTransformer->execute($parsedXml);
                if($data['Error']){
                    return false;
                    // var_dump($data);exit;
                }else{
                    return $data;
                }
                // return $data['Error'] ? NULL : $data;
              } catch(\Exception $error) {
                $this->AddError("Error downloading data : $signedUrl : " . $error->getMessage());
                return false;
            }
	}

}
?>
