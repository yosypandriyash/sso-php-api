<?php

namespace App\Libraries;

interface KeyValueManagerInterface {

    /**
     * @param string $keyName
     * @param string $uniqueId
     * @param $value
     * @return bool
     */
    public function setKey(string $keyName, string $uniqueId, $value = null): bool;

    /**
     * @param string|null $keyName
     * @param string|null $uniqueId
     * @return bool
     */
    public function existsKey(string $keyName = null, string $uniqueId = null): bool;

    /**
     * @param string|null $keyName
     * @param string|null $uniqueId
     * @return mixed
     */
    public function getValue(string $keyName = null, string $uniqueId = null);

    /**
     * @param string $uniqueId
     * @return bool
     */
    public function removeKey(string $uniqueId): bool;

    /**
     * @param string $uniqueId
     * @return KeyValueObject
     */
    public function getAllAsObject(string $uniqueId): KeyValueObject;
}