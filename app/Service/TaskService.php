<?php
/**
 * Created by PhpStorm   User: AlicFeng   DateTime: 18-11-22 下午2:24
 */

namespace App\Service;

use Log;


use App\Jobs\TaskQueue;

class TaskService
{
    /**
     * @functionName   编排任务执行入口
     * @description    编排任务执行入口
     * @version        v1.0.0
     * @author         Alicfeng
     * @datetime       18-11-23 上午10:34
     * @param string $taskCode 任务编排编码
     * @param array $devices 设备列表
     * @param integer $frequency 操控频率
     * @return bool
     * @response       []
     */
    public function run($taskCode, $devices, $frequency)
    {
        echo "{$frequency} playbook running...";
        Log::info("{$frequency} playbook running...");
        $taskList = config('playbook.' . $taskCode);
        if (null == $taskList) {
            return false;
        }
        foreach ($devices as $deviceItem) {
            TaskQueue::dispatch($taskList, $deviceItem);
            // 频率控制
            sleep($frequency);
        }
        return true;
    }
}