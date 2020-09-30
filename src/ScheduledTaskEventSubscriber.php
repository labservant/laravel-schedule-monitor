<?php

namespace Spatie\ScheduleMonitor;

use Illuminate\Console\Events\ScheduledTaskFailed;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Events\ScheduledTaskSkipped;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Contracts\Events\Dispatcher;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTask;

class ScheduledTaskEventSubscriber
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            ScheduledTaskStarting::class,
            function (ScheduledTaskStarting $event) { optional(MonitoredScheduledTask::findForTask($event->task))->markAsStarting($event); }
        );

        $events->listen(
            ScheduledTaskFinished::class,
            function (ScheduledTaskFinished $event) { optional(MonitoredScheduledTask::findForTask($event->task))->markAsFinished($event); }
        );

        $events->listen(
            ScheduledTaskFailed::class,
            function (ScheduledTaskFailed $event) { optional(MonitoredScheduledTask::findForTask($event->task))->markAsFailed($event); }
        );

        $events->listen(
            ScheduledTaskSkipped::class,
            function (ScheduledTaskSkipped $event) { optional(MonitoredScheduledTask::findForTask($event->task))->markAsSkipped($event); }
        );
    }
}
