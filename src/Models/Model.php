<?php

namespace PHPHos\Yii\Models;

use PHPHos\Yii\Models\ActiveRecord;

abstract class Model extends ActiveRecord
{
    /**
     * 字段布尔值: TRUE.
     */
    const BOOL_TRUE = '1';
    /**
     * 字段布尔值: FALSE.
     */
    const BOOL_FALSE = '0';

    /**
     * 得到错误信息.
     *
     * @return string
     */
    public function getError(): string
    {
        $errors = array_values($this->firstErrors);
        return reset($errors);
    }

    /**
     * 字段映射.
     *
     * @return array
     */
    protected function map(): array
    {
        $attributes = $this->attributes();

        return array_combine($attributes, $attributes);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [[array_keys($this->toArray() ?? []), 'safe']];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return $this->map();
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $res = [];
        $map = $this->map();
        $formName === null || $data = $data[$formName];

        foreach ($data as $key => $value) {
            $field = $map[$key] ?? $key;

            is_null($value) || $res[$field] = $value;
        }

        return parent::load($res, '');
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        $fields = $this->map();

        if (array_key_exists($name, $fields)) {
            return parent::__get($fields[$name]);
        }

        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        $fields = $this->map();

        if (array_key_exists($name, $fields)) {
            parent::__set($fields[$name], $value);
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function __isset($name)
    {
        $fields = $this->map();

        if (array_key_exists($name, $fields)) {
            parent::__isset($fields[$name]);
        } else {
            parent::__isset($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function __unset($name)
    {
        $fields = $this->map();

        if (array_key_exists($name, $fields)) {
            parent::__unset($fields[$name]);
        } else {
            parent::__unset($name);
        }
    }
}
