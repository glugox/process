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


use Glugox\Process\Model\Instance;

interface ProcessServiceInterface
{

    /**
     * @param $code
     * @param array $data
     */
    public function getProcess($code, array $data);


    /**
     * @param Instance $process
     * @return Instance
     */
    public function startProcess( Instance $process );

    /**
     * @param Instance $process
     * @return Instance
     */
    public function finishProcess( Instance $process, $error = null );


    /**
     * @param Instance $process
     * @return Instance
     */
    public function updateProcess( Instance $process, $data= [] );
}