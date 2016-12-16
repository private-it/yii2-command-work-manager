<?php

namespace PrivateIT\command\workManager;

use yii\base\Object;
use yii\console\Exception;

class WorkManagerIterator extends Object
{
    /**
     * @var integer
     */
    public $lastId = 0;
    /**
     * @var integer
     */
    public $sleep = 10;
    /**
     * @var string
     */
    public $runtimeDir = '@runtime';
    /**
     * @var resource
     */
    protected $lockFileHandle;
    /**
     * @var string
     */
    protected $lockFilePath;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->runtimeDir = \Yii::getAlias($this->runtimeDir);
        if (!is_dir($this->runtimeDir)) {
            mkdir($this->runtimeDir, 0755, true);
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function inProcess($id)
    {
        $this->lastId = $id;

        $this->lockFilePath = $this->runtimeDir . '/' . $id . '.lock';
        if (file_exists($this->lockFilePath)) {
            throw new Exception('Lock file exist: ' . $this->lockFilePath);
        }

        $this->lockFileHandle = fopen($this->lockFilePath, 'w+');
        if (!$this->lockFileHandle || !flock($this->lockFileHandle, LOCK_EX | LOCK_NB)) {
            throw new Exception('lock');
        }

        return false;
    }

    /**
     * Clear runtime files
     */
    public function clear()
    {
        if (is_resource($this->lockFileHandle)) {
            flock($this->lockFileHandle, LOCK_UN);
            fclose($this->lockFileHandle);
        }
        @unlink($this->lockFilePath);
    }

    public function sleep()
    {
        sleep($this->sleep);
    }
}