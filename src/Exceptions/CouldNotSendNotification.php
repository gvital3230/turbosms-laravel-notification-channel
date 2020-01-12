<?php

namespace NotificationChannels\TurboSMS\Exceptions;

use Exception;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Descriptive error message.");
    }

    /**
     * Thrown when we're unable to communicate with smspoh.
     *
     * @param Exception $exception
     *
     * @return CouldNotSendNotification
     */
    public static function couldNotCommunicateWithEndPoint(Exception $exception): self
    {
        return new static("The communication with endpoint failed. Reason: {$exception->getMessage()}", $exception->getCode(), $exception);
    }

    /**
     * Thrown when we're unable to communicate with smspoh.
     *
     * @param Exception $exception
     *
     * @return CouldNotSendNotification
     */
    public static function couldNotAuthorize(Exception $exception): self
    {
        return new static("The authorization on endpoint failed. Reason: {$exception->getMessage()}", $exception->getCode(), $exception);
    }
}
