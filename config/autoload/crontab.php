<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\Crontab\Crontab;

return [
    'enable' => false,
//    'crontab' => [
//        // Callback type timed task (default)
//        (new Crontab())->setName('Foo')->setRule('* * * * *')->setCallback([App\Task\FooTask::class, 'execute'])->setMemo('This is an example timed task'),
//        // Command type timed task
//        (new Crontab())->setType('command')->setName('Bar')->setRule('* * * * *')->setCallback([
//            'command' => 'swiftmailer:spool:send',
//            // (optional) arguments
//            'fooArgument' => 'barValue',
//            // (optional) options
//            '--message-limit' => 1,
//            // Remember to add it, otherwise it will cause the main process to exit
//            '--disable-event-dispatcher' => true,
//        ])->setEnvironments(['develop', 'production']),
//    ],
];
