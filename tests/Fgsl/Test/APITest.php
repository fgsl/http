<?php
/**
 * Fgsl Http - a free HTTP requester
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @link      https://github.com/fgsl/http for the canonical source repository
 * @copyright Copyright (c) 2018-2021 FGSL (http://www.fgsl.eti.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */
namespace Fgsl\Test;

use Fgsl\Http\Http;
use PHPUnit\Framework\TestCase;

/**
 * 
 * @package    Fgsl
 * @subpackage Test
 */
class APITest extends TestCase
{
    /**
     * ensures creation of container object
     */
    public function testAPIclasses()
    {
        $http = new Http();
        $this->assertTrue(is_object($http));
        
        $ctx = Http::getContext('GET', null);
        @$response = Http::request("http://www.horalegalbrasil.mct.on.br/SincronismoPublico.html", $ctx);
        
        $this->assertStringContainsString('Sincronismo', $response);
        
        @$response = Http::curl("http://www.horalegalbrasil.mct.on.br/SincronismoPublico.html");
        
        $this->assertStringContainsString('Sincronismo', $response);

        $this->assertEquals(200,Http::getLastResponseCode());
        
        @$response = Http::curlFromShell("http://www.horalegalbrasil.mct.on.br/SincronismoPublico.html");
        
        $this->assertStringContainsString('Sincronismo', $response);
    }

    /**
     * check exception throwing     * 
     */
    public function testExceptionThrowingInRequestMethod()
    {
        $this->expectException(\TypeError::class);

        $http = new Http();
        $this->assertTrue(is_object($http));
        
        $ctx = Http::getContext('GET', null);
        @$response = Http::request("http://www.horailegalbrasil.mct.on.br/SincronismoPublico.html", $ctx);        
        
    }    
}
