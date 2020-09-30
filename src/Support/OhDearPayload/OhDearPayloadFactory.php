<?php

namespace Spatie\ScheduleMonitor\Support\OhDearPayload;

use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;
use Spatie\ScheduleMonitor\Support\OhDearPayload\Payloads\FailedPayload;
use Spatie\ScheduleMonitor\Support\OhDearPayload\Payloads\FinishedPayload;
use Spatie\ScheduleMonitor\Support\OhDearPayload\Payloads\Payload;

class OhDearPayloadFactory
{
    public static function createForLogItem(MonitoredScheduledTaskLogItem $logItem): ?Payload
    {
        $payloadClasses = [
            FailedPayload::class,
            FinishedPayload::class,
        ];

        $payloadClass = collect($payloadClasses)
            ->first(function (string $payloadClass) { return $payloadClass::canHandle($logItem); });

        if (! $payloadClass) {
            return null;
        }

        return new $payloadClass($logItem);
    }
}
