<?php
use Fgsl\Http;
use Fgsl\Test\Core\APITest;
/**
 * Fgsl Http - a free http requester
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br.br>
 * @link      https://github.com/fgsl/http for the canonical source repository
 * @copyright Copyright (c) 2016 SERPRO (http://www.serpro.gov.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */
require __DIR__ . '/Psr4AutoloaderClass.php';
$psr4 = new \Psr4AutoloaderClass();
$psr4->addNamespace('Fgsl', __DIR__ . '/Fgsl');
$psr4->addNamespace('Fgsl', __DIR__ . '/../src/Fgsl');
$psr4->register();

APITest::setBasePath(__DIR__);
