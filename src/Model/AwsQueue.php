<?php
/**
 * Created by PhpStorm.
 * User: wolle4
 * Date: 05.09.17
 * Time: 15:48
 */

namespace Guj\DataPush\Model;

/**
 * Representation of one aws queue
 *
 * @package Guj\DataPush\Model
 */
class AwsQueue
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $arn;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getArn()
    {
        return $this->arn;
    }

    /**
     * @param string $arn
     */
    public function setArn($arn)
    {
        $this->arn = $arn;
    }

}