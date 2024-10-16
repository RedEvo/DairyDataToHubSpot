<?php
/*
 * @author    Phil E. Taylor <phil@phil-taylor.com>
 * @copyright Copyright (C) 2024 Red Evolution Limited.
 * @license   GPL
 */

namespace RedEvo;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

require_once __DIR__ . '/../vendor/autoload.php';

class LogHander
{
    public const string logDir = __DIR__ . "/../logs/";

    public const string logFile = self::logDir . "log.log";

    public const string logFileRotate = self::logDir . "log.rotate.log";

    private readonly Logger $logger;

    public function __construct()
    {
        $streamHandler       = new StreamHandler(self::logFile, Level::Debug);
        $rotatingFileHandler = new RotatingFileHandler(self::logFileRotate, 1);

        $lineFormatter = new LineFormatter();

        $streamHandler->setFormatter($lineFormatter);
        $rotatingFileHandler->setFormatter($lineFormatter);

        $this->logger = new Logger('RedEvo', [$streamHandler, $rotatingFileHandler], [new UidProcessor()]);
    }

    public function __call(string $method, mixed $args)
    {
        $this->logger->$method(...$args);
    }
}
