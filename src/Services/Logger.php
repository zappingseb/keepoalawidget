<?php

namespace KeepoalaWidget2\Services;

use Plenty\Log\Contracts\LoggerContract;
use Plenty\Plugin\Log\Loggable;

/**
 * Class Logger
 */
class Logger //implements LoggerContract
{
    use Loggable;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var LoggerContract
     */
    private $logger;
    private $referenceType;
    private $referenceValue;

    /**
     * Logger constructor.
     *
     */
    public function __construct() {
        $this->identifier = __CLASS__;
        $this->logger = $this->getLogger($this->identifier);
    }

    /**
     * @param string $identifier
     *
     * @return Logger
     */
    public function setIdentifier(string $identifier)
    {
        $this->logger = $this->getLogger($identifier);
        $this->logger->setReferenceType($this->referenceType);
        $this->logger->setReferenceValue($this->referenceValue);

        return $this;
    }


    /**
     * @param string $code
     * @param array $additionalInfo
     *
     * @return Logger
     */
    public function info(
        string $code,
        $additionalInfo = null
    ) {

        $this->getPlentyLogger()->info("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param string $code
     * @param array $additionalInfo
     *
     * @return Logger
     */
    public function notice(
        string $code,
        $additionalInfo = null
    ) {
        
        $this->getPlentyLogger()->notice("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param string $code
     * @param array $additionalInfo
     *
     * @return Logger
     */
    public function warning(
        string $code,
        $additionalInfo = null
    ) {
       
        $this->getPlentyLogger()->warning("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param string $code
     * @param array|null $additionalInfo
     *
     * @return Logger
     */
    public function error(
        string $code,
        $additionalInfo = null
    ) {
        $this->getPlentyLogger()->error("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param string $code
     * @param array $additionalInfo
     *
     * @return Logger
     */
    public function critical(
        string $code,
        $additionalInfo = null
    ) {
        $this->getPlentyLogger()->critical("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param string $code
     * @param array $additionalInfo
     *
     * @return Logger
     */
    public function alert(
        string $code,
        $additionalInfo = null
    ) {
        $this->getPlentyLogger()->alert("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param $code
     * @param array $additionalInfo
     *
     * @return Logger
     */
    public function emergency(
        $code,
        $additionalInfo = null
    ) {
        $this->getPlentyLogger()->emergency("KeepoalaWidget2" . '::' . $code, $additionalInfo);

        return $this;
    }

    /**
     * @param \Exception $exception
     * @param int $traceDepth
     *
     * @return Logger
     */
    public function logException(
        \Exception $exception
    ) {
        $this->getPlentyLogger()->logException($exception);

        return $this;
    }

    /**
     * @param string $referenceType
     *
     * @return Logger
     */
    public function setReferenceType(
        string $referenceType
    ) {
        $this->referenceType = $referenceType;
        $this->logger->setReferenceType($referenceType);

        return $this;
    }

    /**
     * @param $referenceValue
     *
     * @return Logger
     */
    public function setReferenceValue(
        $referenceValue
    ) {
        $this->referenceValue = $referenceValue;
        $this->logger->setReferenceValue($referenceValue);

        return $this;
    }

    /**
     * @return LoggerContract
     */
    private function getPlentyLogger()
    {
        return $this->logger;
    }
}