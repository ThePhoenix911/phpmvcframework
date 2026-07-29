<?php

namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // the ampersand (&) is used to ensure the variable is passed by reference instead of a copy
        // enabling a direct modification of the variable's value without creating a new copy
        // The actual value of 'remove' will be set to true
        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be removed
            $flashMessage['remove'] = true;
        }

        // pass back the modified array
        $_SESSION[self::FLASH_KEY] = $flashMessages;

    }


    public function setFlash(string $key, string $message)
    {

        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash(string $key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        // Iterate over marked to be removed flash messages and remove them
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        // pass back the modified array
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}