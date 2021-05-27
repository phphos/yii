<?php

namespace PHPHos\Yii\Models;

use PHPHos\Yii\Models\Redis;

class RedisKey extends Redis
{
    /**
     * 会话信息.
     *
     * @param string $token TOKEN.
     * @return string
     */
    public static function session(string $token): string
    {
        return static::key('SESSION', $token);
    }
}
