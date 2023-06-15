<?php
declare(strict_types = 1);
namespace Fgsl\Http;

/**
 * Fgsl Http - a free http requester
 *
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br.br>
 * @link https://github.com/fgsl/http for the canonical source repository
 * @copyright Copyright (c) 2016 FGSL (http://www.fgsl.eti.br)
 * @license https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */
class Http
{
    private static $responseCode = null;

    public static function getLastResponseCode()
    {
        return self::$responseCode;
    }

    /**
     * Send a HTTP request
     *
     * @param string $url
     * @param resource $context
     * @throws TypeError if response is not a string
     * @return string HTTP response
     */
    public static function request(string $url, $context, bool $jsonDecode = false): string
    {
        $response = @file_get_contents($url, false, $context);
        $response = ($jsonDecode ? json_decode($response) : $response);
        if (is_bool($response)){
            throw new \TypeError('Return value must be of type string, bool returned');
        }
        return $response;
    }

    /**
     * Create a context for a HTTP request
     *
     * @param string $method
     *            HTTP method
     * @param string $header
     *            HTTP headers separated by \r\n
     * @param string $content
     *            request data
     * @param boolean $jsonEncode
     *            if data is JSON
     * @param boolean $ignoreSSL
     *            ignore certificates
     * @return resource
     */
    public static function getContext(string $method = 'GET', string $header = null, string $content = null, bool $jsonEncode = false, array $httpOptions = [], bool $ignoreSSL = true)
    {
        // http://www.php.net/manual/en/context.http.php
        $http = [
            'method' => $method
        ];
        if (! is_null($header)) {
            $http['header'] = $header;
        }
        if (! is_null($content)) {
            $http['content'] = ($jsonEncode ? json_encode($content) : $content);
        }
        if (! empty($httpOptions)) {
            $http = array_merge($http, $httpOptions);
        }

        $ssl = [];
        if ($ignoreSSL) {
            $ssl = [
                // avoid certificates
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ];
        }

        $context = stream_context_create(array(
            'http' => $http,
            'ssl' => $ssl
        ));
        return $context;
    }

    /**
     * Create and execute a HTTP request using CURL
     *
     * @param string $url
     * @param array $headers    [$header1, $header2,...]
     * @param bool $ignoreSSL   ignore certificates
     * @param array $options    [$option => $value,...]
     * @return string
     */
    public static function curl(string $url, array $headers = [], bool $ignoreSSL = true, array $options = []): string
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_HEADEROPT, CURLHEADER_UNIFIED);
        if ($ignoreSSL) {
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        }
        foreach($options as $option => $value){
            curl_setopt($c, $option, $value);
        }
        $contents = curl_exec($c);
        self::$responseCode = curl_getinfo($c,CURLINFO_RESPONSE_CODE);
        curl_close($c);

        if (is_bool($contents)){
            $contents = "ERROR ON REQUEST $url";
        }
        
        return $contents;
    }
    
    /**
     * Create and execute a HTTP request using CURL from shell
     *
     * @param string $url
     * @param array $headers    [$header1, $header2,...]
     * @param bool $ignoreSSL   ignore certificates
     * @param array $options    [$option => $value,...]
     * @return string
     */
    public static function curlFromShell(string $url, array $headers = [], bool $ignoreSSL = true, array $options = []): string
    {
        $command = "curl $url" . ($ignoreSSL ? ' -k' : '');
        foreach($headers as $header){
            $command .= ' -H "' . $header . '"'; 
        }
        foreach($options as $option){
            $command .= " $option";
	}        
	$response = shell_exec($command);
	if ($response == null){
             throw new \Exception('curl request has returned a null');		
	}
	return $response;
    }    
}
