<?php
namespace Fgsl\Http;

/**
 * Fgsl Http - a free http requester
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br.br>
 * @link      https://github.com/fgsl/http for the canonical source repository
 * @copyright Copyright (c) 2016 FGSLO (http://www.fgsl.eti.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */
class Http
{

    /**
     * Send a HTTP request
     * 
     * @param string $url
     * @param resource $context
     * @return string HTTP response
     */
    public static function request($url, $context, $jsonDecode = false)
    {
        $response = @file_get_contents($url, false, $context);
        return ($jsonDecode ? json_decode($response) : $response);
    }

    /**
     * Create a context for a HTTP request
     * 
     * @param string $method
     *            (HTTP method)
     * @param string $header
     *            HTTP headers separated by \r\n
     * @param string $content
     *            request data
     * @param boolean $jsonEncode
     *            if data is JSON
     * @return resource
     */
    public static function getContext($method = 'GET', $header = null, $content = null, $jsonEncode = false, $httpOptions = [])
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
        $context = stream_context_create(array(
            'http' => $http,
            'ssl' => array(
                // avoid certificates
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        ));
        return $context;
    }
}
