<?php

namespace PrivateIT\command\workManager;
use yii\base\Model;

/**
 * Class WorkManagerTask
 * @package PrivateIT\command\workManager
 *
 * @property string $fileRinTimeDir
 * @property string $fileLastRun
 */
class WorkManagerTask extends Model
{
    public $name;
    public $delay;
    public $command;

    protected $_fileRunTimeDir;
    protected $_fileLastRun;

    public function run()
    {
        exec($this->command . ' &');
        $this->upLastRunTime();
    }

    public function isRunning()
    {
        return !flock($this->getFileLastRun(), LOCK_EX | LOCK_NB);
    }

    public function isDue()
    {
        $nextRunTime = $this->getNextRunTime()->getTimestamp();
        return time() > $nextRunTime;
    }

    public function upLastRunTime()
    {
        fseek($this->getFileLastRun(), 0);
        fwrite($this->getFileLastRun(), date('Y-m-d H:i:s'));
    }

    /**
     * @return \DateTime
     */
    protected function getNextRunTime()
    {
        $lastRunDateTime = $this->getLastRunTime();
        $nextRunDateTime = new \DateTime($lastRunDateTime);
        $nextRunDateTime->modify('+' . $this->delay);
        return $nextRunDateTime;
    }

    protected function getLastRunTime()
    {
        $lastRunFile = $this->getFileLastRun();
        $lastRun = 0;
        if (is_resource($lastRunFile)) {
            $lastRun = strtotime(fread($lastRunFile, 20));
        }
        return date('Y-m-d H:i:s', $lastRun);
    }

    /**
     * @return mixed
     */
    public function getFileLastRun()
    {
        $f = $this->_fileLastRun;
        if (!$f) {
            $f = Yii::getAlias(
                $this->getFileRunTimeDir() . '/' . $this->name . '-' . md5($this->delay . $this->command)
            );
        }
        if (is_string($f) && !file_exists($f)) {
            file_put_contents($f, '');
        }
        if (!is_resource($f)) {
            $f = fopen(Yii::getAlias($f), 'r+');
        }
        return $this->_fileLastRun = $f;
    }

    /**
     * @param mixed $fileLastRun
     */
    public function setFileLastRun($fileLastRun)
    {
        $this->_fileLastRun = $fileLastRun;
    }

    /**
     * @return mixed
     */
    public function getFileRunTimeDir()
    {
        if (!$this->_fileRunTimeDir) {
            $this->_fileRunTimeDir = Yii::getAlias('@runtime/work-manager');
        }
        if (!is_dir($this->_fileRunTimeDir)) {
            mkdir($this->_fileRunTimeDir, 0755, true);
        }
        return $this->_fileRunTimeDir;
    }

    /**
     * @param mixed $fileRinTimeDir
     */
    public function setFileRunTimeDir($fileRinTimeDir)
    {
        $this->_fileRunTimeDir = $fileRinTimeDir;
    }
}