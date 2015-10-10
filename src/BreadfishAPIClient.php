<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 10.10.2015
 * Time: 20:01
 */

namespace lkdevelopment;
use Namshi\JOSE\SimpleJWS;

class BreadfishAPIClient
{
    const CLIENT_VERSION = '0.0.1-dev';
    const SCOPE_AVATAR = 'avatar';
    const SCOPE_REGISTRATION = 'registration';
    const SCOPE_NUM_POSTS = 'num_posts';
    const SCOPE_THANKS = 'thanks';
    const SCOPE_BAN = 'ban';
    const SCOPE_WARNINGS = 'warnings';
    const SCOPE_PROFILE_INFORMATION = 'profile_information';
    const SCOPE_EMAIL = 'email';
    const SCOPE_PRIVATE_MESSAGES = 'private_messages';

    protected $apiToken;

    protected $apiPassword;

    protected $redirectUrl;

    protected $scope;
    private $client_url = 'breadfish.de/oauth/index.php';
    public function __construct($apiToken, $apiPassword)
    {
        $this->apiToken = $apiToken;
        $this->apiPassword = $apiPassword;
    }

    public function setScope(array $scopes)
    {
        $this->scope = implode(",", $scopes);
    }

    public function setRedirectUrl($RedirectUrl)
    {
        $this->redirectUrl = $RedirectUrl;
    }

    public function getOAuthUrl()
    {
        $params = array("token" => $this->apiToken, "redirect" => $this->redirectUrl, "scope" => $this->scope);
        return $this->httpOrHttps().$this->client_url . "?" . http_build_query($params);
    }
    private function httpOrHttps(){
        if(isset($_SERVER['HTTPS'])){
            return "https://";
        } else {
            return "http://";
        }
    }
    public function redirectToBreadfish(){
        if(headers_sent() === false){
            header('Location: '.$this->getOAuthUrl());
        } else {
            echo '<meta http-equiv="refresh" content="0; URL='.$this->getOAuthUrl().'">';
        }
    }

    public function getResponseFromBreadfish(){
        if(isset($_GET['error'])){
            throw new BreadfishAPIException($_GET['error']);
        } else {
            if(isset($_POST['response'])){
                return $this->decodeResponse($_POST['response']);
            } else {
                throw new BreadfishAPIException('response empty');
            }
        }
    }

    private function decodeResponse($response){
        $jws = new SimpleJWS();
        
        return JWT::decode($response,$this->apiPassword);
    }
}