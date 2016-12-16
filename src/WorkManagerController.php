<?php

namespace PrivateIT\command\workManager;

use Yii;
use yii\console\Controller;
use yii\console\Exception;

class WorkManagerController extends Controller
{
    public $logDir = '@runtime/work-manager/logs';
    public $lockFile = '@runtime/work-manager/run.lock';
    public $timeout = 1000000; // 1 second

    protected $_handleLockFile;
    protected $_store;

    public function init()
    {
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
        $this->_handleLockFile = fopen(Yii::getAlias($this->lockFile), 'r+');
        return !flock($this->_handleLockFile, LOCK_EX | LOCK_NB);
    }

    /**
     * @return WorkManagerTask[]
     * @throws Exception
     */
    protected function getTasks()
    {
        $tasks = [];
        $store = json_decode(file_get_contents($this->getStore()), true);
        if (false !== $store) {
            foreach ($store as $attributes) {
                $tasks[] = new WorkManagerTask($attributes);
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
        return file_put_contents($this->getStore(), json_encode($data));
    }

    /**
     * @return string
     */
    public function getStore()
    {
        if (!$this->_store) {
            $this->setStore('@data/work-manager.json');
        }
        if (!file_exists($this->_store)) {
            file_put_contents($this->_store, '[]');
        }
        return $this->_store;
    }

    /**
     * @param string $store
     */
    public function setStore($store)
    {
        $this->_store = Yii::getAlias($store);
    }
}