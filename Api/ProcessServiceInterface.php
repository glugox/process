<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Api;


interface ProcessServiceInterface
{

    /**
     * @param $code
     * @param array $data
     */
    public function getProcess($code, array $data);
}