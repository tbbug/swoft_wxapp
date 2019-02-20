<?php

namespace App\Tasks;

use Swoft\Task\Bean\Annotation\Task;

/**
 * Demo task
 *
 * @Task("demo")
 */
class DemoTask
{
    public function test(int $num)
    {
        sleep($num);
        echo '终端：每' . $num . '秒输出一次，哦耶~' . PHP_EOL;
    }
}
