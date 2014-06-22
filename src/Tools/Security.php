<?php
/**
 * This file is part of the Mackstar.Spout package.
 *
 * (c) Richard McIntyre <richard.mackstar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mackstar\Spout\Tools;

use Mackstar\Spout\Interfaces\SecurityInterface;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class Security implements SecurityInterface
{
    public function createSalt()
    {
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        return sprintf("$2a$%02d$", $cost) . $salt;
    }

    public function encrypt($password, $salt = null)
    {
        if (!$salt) {
            $salt = $this->createSalt();
        }
        return crypt($password, $salt);
    }

    public function match($password, $hash)
    {
        return (crypt($password, $hash) === $hash);
    }
}
