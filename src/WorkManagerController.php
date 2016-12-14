<?php

namespace PrivateIT\command\workManager;

use Yii;
use yii\base\Model;
use yii\base\Object;
use yii\console\Controller;
use yii\console\Exception;

class WorkManagerController extends Controller
{
    public $store = '@data/work-manager.json';
    public $runtime = '@runtime/work-manager/last-run';
    public $logDir = '@runtime/work-manager/logs';
    public $lockFile = '@runtime/work-manager/run.lock';
    public $timeout = 1000000; // 1 second

    protected $handleLockFile;

    public function init()
    {
        $runtime = Yii::getAlias($this->runtime);
        if (!is_dir($runtime)) {
            mkdir($runtime, 0777, true);
        }
        $logDir = Yii::getAlias($this->logDir);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $lockFile = Yii::getAlias($this->lockFile);
        if (!is_file($lockFile)) {
            file_put_contents($lockFile, null);
        }
        parent::init();
    }

    public function actionRun()
    {
        if ($this->isRunning()) {
            die('Process is running!');
        }

        putenv("APP_DIR=" . Yii::getAlias('@app'));
        putenv("LOG_DIR=" . Yii::getAlias($this->logDir));

        while (true) {
            echo date('Y-m-d H:i:s.') . sprintf("%06d", (microtime(true) - floor(microtime(true))) * 1000000) . PHP_EOL;
            foreach ($this->getTasks() as $num => $task) {
                if (!$task->isRunning()) {
                    if ($task->isDue()) {
                        echo 'RUN: [' . $task->name . '] ' . $task->command . PHP_EOL;
                        $task->run();
                    }
                }
            }
            usleep($this->timeout);
        }
    }

    public function actionList()
    {
        echo PHP_EOL;
        $row = ['Num', 'Name', 'Delay', "Command"];
        $rows[] = $row;
        $cols = [strlen($row[0]), strlen($row[1]), strlen($row[2]), strlen($row[3])];
        foreach ($this->getTasks() as $num => $task) {
            $row = [$num + 1, $task->name, $task->delay, $task->command];
            foreach ($row as $i => $cell) {
                $len = strlen($cell);
                if ($len > $cols[$i]) {
                    $cols[$i] = $len;
                }
            }
            $rows[] = $row;
        }

        $mask = [];
        foreach ($cols as $colSize) {
            $mask[] = '%-' . $colSize . '.' . $colSize . 's';
        }
        $mask = '| ' . implode(' | ', $mask) . ' |' . PHP_EOL;
        foreach ($rows as $row) {
            printf($mask, $row[0], $row[1], $row[2], $row[3]);
        }

        echo PHP_EOL;
    }

    public function actionAdd($name, $delay, $command)
    {
        $data = [];
        $tasks = $this->getTasks();
        foreach ($tasks as $task) {
            if ($name == $task->name) {
                continue;
            }
            $data[] = $task->getAttributes();
        }
        $data[] = [
            'name' => $name,
            'delay' => $delay,
            'command' => $command,
        ];
        return $this->setTasks($data);
    }

    public function actionDel($name)
    {
        $data = [];
        $tasks = $this->getTasks();
        foreach ($tasks as $task) {
            if ($task->name == $name) {
                continue;
            }
            $data[] = $task->getAttributes();
        }
        return $this->setTasks($data);
    }

    protected function isRunning()
    {
        $this->handleLockFile = fopen(Yii::getAlias($this->lockFile), 'r+');
        return !flock($this->handleLockFile, LOCK_EX | LOCK_NB);
    }

    /**
     * @return Task[]
     * @throws Exception
     */
    protected function getTasks()
    {
        $tasks = [];
        $store = json_decode(file_get_contents(Yii::getAlias($this->store)), true);
        if (false !== $store) {
            foreach ($store as $attributes) {
                $tasks[] = new Task($attributes);
            }
        } else {
            throw new Exception('File "' . $store . '" not valid!');
        }
        return $tasks;
    }

    /**
     * @param $data
     * @return int
     */
    protected function setTasks($data)
    {
        return file_put_contents(Yii::getAlias($this->store), json_encode($data));
    }
}

/**
 * Class Task
 * @package PrivateIT\command\workManager
 *
 * @property string $fileRinTimeDir
 * @property string $fileLastRun
 */
class Task extends Model
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