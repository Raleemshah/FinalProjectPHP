<?php

class PasswordGenerator
{
    public function generate(
        $length,
        $uppercase,
        $lowercase,
        $numbers,
        $special
    ) {

        $upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $lowerChars = 'abcdefghijklmnopqrstuvwxyz';

        $numberChars = '0123456789';

        $specialChars = '!@#$%^&*()_+-={}[]<>?/';

        $passwordArray = [];

        // Uppercase
        for ($i = 0; $i < $uppercase; $i++) {

            $passwordArray[] =
                $upperChars[random_int(
                    0,
                    strlen($upperChars) - 1
                )];
        }

        // Lowercase
        for ($i = 0; $i < $lowercase; $i++) {

            $passwordArray[] =
                $lowerChars[random_int(
                    0,
                    strlen($lowerChars) - 1
                )];
        }

        // Numbers
        for ($i = 0; $i < $numbers; $i++) {

            $passwordArray[] =
                $numberChars[random_int(
                    0,
                    strlen($numberChars) - 1
                )];
        }

        // Special Characters
        for ($i = 0; $i < $special; $i++) {

            $passwordArray[] =
                $specialChars[random_int(
                    0,
                    strlen($specialChars) - 1
                )];
        }

        // Shuffle password
        shuffle($passwordArray);

        // Convert array to string
        $password = implode('', $passwordArray);

        // Ensure exact length
        return substr($password, 0, $length);
    }
}