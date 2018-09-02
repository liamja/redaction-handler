<?php declare(strict_types=1);

namespace Liamja\RedactionHandler;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\HandlerWrapper;

/**
 * Log Redaction Handler.
 *
 * Proxies log handlers, redacting sensitive data before
 * passing down to the original handler that it wraps.
 */
class RedactionHandler extends HandlerWrapper
{
    /**
     * If these functions are found in the log record
     * redact the arguments so sensitive user data
     * is not written to logs by the log handler.
     *
     * @var string
     */
    private $functionsToRedact;

    /**
     * RedactionHandler constructor.
     *
     * @param HandlerInterface $handler
     * @param array $functionsToRedact
     */
    public function __construct(HandlerInterface $handler, array $functionsToRedact = [])
    {
        $this->functionsToRedact = implode($functionsToRedact, '|');

        parent::__construct($handler);
    }

    /**
     * Extend Monolog's handle() method to filter out passwords from stack traces.
     *
     * @param array    $record
     *
     * @return bool
     */
    public function handle(array $record)
    {
        /**
         * Replace everything between the function's
         * brackets with the word REDACTED to hide
         * that function's sensitive arguments.
         */
        $regex = "/(?<name>$this->functionsToRedact)\((?<arguments>.*)\)\n/m";
        $substitution = '$1(REDACTED)\n';

        array_walk_recursive($record, function (&$value) use ($regex, $substitution ) {
            if (!is_scalar($value)) {
                return;
            }

            $value = preg_replace($regex, $substitution, $value);
        });

        /**
         * Pass the redacted record to the wrapped handler
         * so that it can continue to process the entry.
         */
        return parent::handle($record);
    }
}
