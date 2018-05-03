<?php
/**
 * Fgsl Http - a free HTTP requester
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @link      https://github.com/fgsl/http for the canonical source repository
 * @copyright Copyright (c) 2018 FGSL (http://www.fgsl.eti.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */
namespace Fgsl\Test\Core;

use Fgsl\Http\Http;
/**
 * 
 * @package    Fgsl
 * @subpackage Test
 */
class APITest extends \PHPUnit_Framework_TestCase
{
    /**
     * Base path of application
     * 
     * @var string
     */
    private static $basePath = NULL;

    /**
     * 
     * @param string $basePath
     */
    public static function setBasePath($basePath)
    {
        self::$basePath = $basePath;
    } 

    /**
     * ensures creation of container object
     */
    public function testAPIclasses()
    {
        $http = new Http();
        $this->assertTrue(is_object($http));
        
        $ctx = Http::getContext('GET', null);
        @$response = Http::request("http://www.on.br/index.php/pt-br/busca.html", $ctx);
        
        $this->assertContains('Tecnologia', $response);

    }
}
