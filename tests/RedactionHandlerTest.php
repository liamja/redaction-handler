<?php declare(strict_types=1);

namespace Liamja\RedactionHandler\Tests;

use Liamja\RedactionHandler\RedactionHandler;
use Monolog\Handler\TestHandler;
use Monolog\Logger;

class RedactionHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testRedactionHandlerCanBeInstantiated(): void
    {
        $redactionHandler = new RedactionHandler(new TestHandler());

        $this->assertInstanceOf(RedactionHandler::class, $redactionHandler);
    }

    public function testRedactionHandlerRedacts(): void
    {
        $redactionHandler = new RedactionHandler(new TestHandler());

        $logger = new Logger('foo');
        $testHandler = new TestHandler();
        $redactionHandler = new RedactionHandler($testHandler, ['functionToRedact']);

        $logger->pushHandler($redactionHandler);

        $this->functionToRedact($logger);

        list($record) = $testHandler->getRecords();

        $this->assertRegExp('/functionToRedact\(REDACTED\)/', $record['message']);
        $this->assertRegExp('/functionToRedact\(REDACTED\)/', $record['formatted']);
    }

    private function functionToRedact($logger): void
    {
        $logger->warning(new \Exception);
    }
}
