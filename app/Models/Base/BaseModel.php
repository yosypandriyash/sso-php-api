<?php

namespace App\Models\Base;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class BaseModel extends Model {

    protected $skipValidation = true;

    private $modelsMapper;
    private $foreignRelationsCache = [];

    protected $table;
    protected $mapper;
    protected $lastSqlError;
    protected $lastInsertionId;
    protected $validationErrors = [];
    protected $tableForeignRelations;
    protected $injectForeignTablesDependencies;
    protected $databaseConnection;

    const PRE_INSERT_ACTION = 1;
    const PRE_UPDATE_ACTION = 2;
    const PRE_DELETE_ACTION = 3;
    const PRE_SELECT_ACTION = 4;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        helper('string');

        $this->databaseConnection = $this->db->getConnection();
    }

    public function getTable(){
        return $this->table;
    }

    public function getLastSqlError()
    {
        return $this->lastSqlError;
    }

    public function getLastInsertionId()
    {
        return $this->lastInsertionId;
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    public function getTableForeignRelations($key = null) {}

    public function getPrimaryKeyValue() {}

    public function getMapper($var = null) {}

    /* Common MySQL functions */
    public function getOneById($id = null)
    {
        if (is_null($id)) {
            $id = $this->getPrimaryKeyValue();
        }

        $primaryKeyName = $this->primaryKey;

        return $this->getOneByKey($primaryKeyName, $id);
    }

    public function toMappedArray()
    {
        try {
            return $this->getArrayPropertiesFromObject();

        } catch (\Exception $exception) {
            return null;
        }
    }

    public function query($sqlQuery, $convertToModel = true)
    {
        $result = $this->db->query($sqlQuery)->getResult($this->returnType);

        if ($convertToModel) {
            return $this->parseResultToClassObject($result);
        } else {
            return $result;
        }
    }

    public function getAllWithDependencies(array $filters, array $dependencies = []): ?array
    {
        $thisTable = $this->table;
        $thisTableMapper = $this->mapper;
        $thisTableRelations = $this->tableForeignRelations;
        $defaultDependencies = $dependencies;

        $separator = '_0000_';
        $cacheDependencies = [];
        $tablesClasses = [$thisTable => new $this()];

        $mappers = [
            $thisTable => $thisTableMapper
        ];

        $queries = [];
        foreach ($thisTableMapper as $key => $column) {
            $queries[] = $thisTable . '.' . $column . ' as ' . $thisTable . $separator . $column;
        }

        $joinTables = [];
        foreach ($dependencies as $dependency => $class) {
            if (class_exists($class)) {
                $classModel = new $class;
                $mapper = $classModel->getMapper();
                $table = $classModel->getTable();

                $mappers[$table] = $mapper;
                $classParts = explode('\\', $class);
                $cacheDependencies[$classParts[count($classParts) - 1]] = [
                    'class' => $classModel,
                    'table' => $table,
                    'mapper' => $mapper
                ];

                $tablesClasses[$table] = $classModel;

                $dependencies[$dependency] = $cacheDependencies[$classParts[count($classParts) - 1]];

                foreach ($mapper as $key => $column) {
                    $queries[] = $table . '.' . $column . ' as ' . $table . $separator . $column;
                }
            }
        }

        foreach ($thisTableRelations as $localKey => $remoteKey) {

            $remoteParts = explode('.', $remoteKey);
            $remoteClassName = $remoteParts[0];
            $remoteProperty = $remoteParts[1];

            if (!isset($cacheDependencies[$remoteClassName])) {
                return null;
            }

            $remoteModel = $cacheDependencies[$remoteClassName];

            $remoteKey = [
                'table' => $remoteModel['table'],
                'property' => $remoteModel['mapper'][$remoteProperty]
            ];

            $joinTables[$thisTableMapper[$localKey]] = $remoteKey;
        }

        $sqlQuery = 'SELECT ';
        $sqlQuery .= implode(', ', $queries) . ' FROM ' . $thisTable;

        $queries = [];
        foreach ($joinTables as $localKey => $remoteKey) {
            $queries[] = ' JOIN ' . $remoteKey['table'] . ' ON ' . $thisTable . '.' . $localKey . ' = ' . $remoteKey['table'] . '.' . $remoteKey['property'];
        }

        $sqlQuery .= implode(' ', $queries) . ' WHERE ';

        $queries = [];
        foreach ($filters as $filterKey => $filterValue) {
            $filterParts = explode('.', $filterKey);
            $filterDependencyName = $filterParts[0];
            $filterTable = $dependencies[$filterDependencyName]['table'];
            $filterColumn = $filterParts[1];

            $mapColumn = $dependencies[$filterDependencyName]['mapper'][$filterColumn];

            // pending fix: check preg_match($filetrKey, [  !=, >, <, %, like, etc...])
            $queries[] = $filterTable . '.' . $mapColumn . ' = \'' . $filterValue . '\'';
        }

        $sqlQuery .= implode(' AND ', $queries);

        $queryResult = $this->query($sqlQuery, false);

        $return = [];
        foreach ($queryResult as $result) {
            $item = [];
            foreach ($result as $resultItemKey => $resultValue) {
                $keyParts = explode($separator, $resultItemKey);
                $table = $keyParts[0];
                $column = $keyParts[1];
                $item[$table][$column] = $resultValue;
            }

            $return[] = $item;
        }

        $defaultDependencies = array_flip($defaultDependencies);

        foreach ($tablesClasses as $tablesClassName => $tablesClass) {
            foreach ($return as $index => $line) {
                foreach ($line as $tableName => $content) {
                    if ($tablesClassName === $tableName) {
                        $return[$index][$defaultDependencies[get_class($tablesClass)]] = $tablesClass->newFromArray($content);
                        unset($return[$index][$tableName]);
                    }
                }
            }
        }

        return $return;
    }

    public function getAll($options = [])
    {
        $result = $this->db->table($this->table)->getWhere($options)->getResult($this->returnType);
        return $this->parseResultToClassObject($result);
    }

    public function getFirst($options = [])
    {
        $options = $this->parseMapperKeys($options);
        $result = [$this->db->table($this->table)->getWhere($options)->getFirstRow($this->returnType)];
        return $this->parseResultToClassObject($result, true);
    }

    private function parseMapperKeys($filter)
    {
        if (!is_array($filter)) {
            $keyName = $this->getMapper($filter);

            if ($keyName !== null) {
                return $keyName;
            }

            return $filter;
        }

        foreach ($filter as $key => $value) {
            $keyName = $this->getMapper($key);

            if ($keyName !== null) {
                $filter[$keyName] = $value;
                unset($filter[$key]);
            }
        }

        return $filter;
    }

    public function getOneByKey($key, $value)
    {
        $key = $this->parseMapperKeys($key);

        $queryResult = $this->db->table($this->table)->getWhere([$key => $value])->getFirstRow($this->returnType);
        return $this->parseResultToClassObject([$queryResult], true);
    }

    public function getAllByKey($key, $value) {
        $key = $this->parseMapperKeys($key);
        $queryResult = $this->db->table($this->table)->getWhere([$key => $value])->getResult($this->returnType);
        return $this->parseResultToClassObject($queryResult);
    }

    public function save($data = []) : bool
    {
        // Construct getter function
        $id = $this->getPrimaryKeyValue();
        $objectPropertyValues = $this->getArrayPropertiesFromObject();

        if (!is_null($id) && strlen($id) > 0) {
            // Update if id exists in db table
            $updateByIdCondition = [$this->primaryKey => $id];
            unset($objectPropertyValues[$this->primaryKey]); // Remove primary_key from update data

            try {
                $success = (bool) $this->db->table($this->table)->update($objectPropertyValues, $updateByIdCondition);
            } catch (\Exception $e) {
                $this->lastSqlError = $e->getMessage();
                $success = false;
            }

        } else {
            // Insert / create new table row
            try {
                $success = (bool) $this->db->table($this->table)->insert($objectPropertyValues);
            } catch (\Exception $e) {
                $this->lastSqlError = $e->getMessage();
                $success = false;
            }
        }

        $this->lastInsertionId = $this->db->insertID();
        return $success;
    }

    private function getArrayPropertiesFromObject($object = null)
    {
        if (is_null($object)) {
            $object = $this;
        }

        /** @var BaseModel $mapper */
        $mapper = $object->getMapper();

        $arrayProperties = [];

        foreach ($mapper as $mapKey => $mapValue) {
            // Getter;
            $arrayProperties[$mapValue] = $this->$mapKey;
        }

        return $arrayProperties;
    }

    private function insertFromObject($object)
    {
        /** @var BaseModel $mapper */
        $mapper = $object->getMapper();

        $insertArray = [];

        foreach ($mapper as $mapKey => $mapValue) {
            // Getter;
            $getterMethod = 'get' . ucfirst($mapKey);
            $value = call_user_func([$object, $getterMethod], null);
            //
            $insertArray[$mapValue] = $value;
        }

        $response = (bool) $this->db->table($this->table)->insert($insertArray);
        $this->lastInsertionId = $object->insertID();
        return $response;
    }


    private function parseResultToClassObject($data, $uniqueResult = false)
    {
        // check if is array or object and then create new object of self class
        $result = [];

        if (!is_array($data)) {
            return $result;
        }

        foreach ($data as $item) {

            if (!$item) {
                continue;
            }

            if ($this->returnType === 'object') {
                $elem = $this->newFromObject($item);
                array_push($result, $elem);
            }

            if ($this->returnType === 'array') {
                $elem = $this->newFromArray($item);
                array_push($result, $elem);
            }

        }

        if ($uniqueResult && sizeof($result) === 1) {
            return $result[0];
        }

        if ($uniqueResult && empty($result)) {
            return null;
        }

        return $result;
    }

    private function newFromObject($object = null)
    {
        $resultArray = $this->getArrayPropertiesFromObject($object);
        return $this->newFromArray($resultArray);
    }

    public function newFromArray($mysqlResultArray = [])
    {
        $objectProto = new $this;
        // check for mapper (exists, etc)
        $mapper = array_flip($this->mapper);

        // transform sql table properties to setters of table model object
        foreach ($mysqlResultArray as $key => $value) {

            // check if sql result array has translate in class mapper:
            if (isset($mapper[$key])) {
                $currentProperty = $mapper[$key];
                $testMethod = 'set' . ucfirst($currentProperty);

                if ($objectProto->injectForeignTablesDependencies === true) {

                    $foreignRelations = $objectProto->getTableForeignRelations($currentProperty);

                    if (!is_null($foreignRelations)) {

                        $className = substr($foreignRelations, 0, stripos($foreignRelations, '.'));
                        $id = $value;

                        // test if value in cache
                        if (isset($this->foreignRelationsCache[$className])) {

                            if (isset($this->foreignRelationsCache[$className][$id])) {
                                $value = $this->foreignRelationsCache[$className][$id];
                            }

                        } else {
                            $value = $this->getOneResultByClassModelAndId($className, $id);
                            $this->foreignRelationsCache[$className][$id] = $value;
                        }
                    }
                }

                // if has translate, create setter and check if exists in object methods
                if (method_exists($objectProto, $testMethod)) {
                    call_user_func([$objectProto, $testMethod], $value);
                }
            }
        }

        // return prepared class object item
        return $objectProto;
    }

    private function getOneResultByClassModelAndId($classModel, $id)
    {
        $modelName = $this->getModelsMapper($classModel);

        $modelProto = new $modelName;
        return $modelProto->getOneById($id);
    }

    private function getModelsMapper($key = null)
    {
        if (is_null($this->modelsMapper)) {
            $this->modelsMapper = require_once(__DIR__ . '\\modelsMapper.php');
        }

        return isset($key) ? (isset($this->modelsMapper[$key]) ? $this->modelsMapper[$key] : null) : $this->modelsMapper;
    }

    protected function validateField($declaration, $var, $sqlAction = null)
    {
        // validate key
        $declarationKey = $declaration['key'];

        // validate extra
        $declarationExtra = $declaration['extra'];

        $isPrimaryKey = ($declarationKey === 'PRI');
        $isUnique = ($declarationKey === 'UNI');
        $isAutoIncrement = ($declarationExtra === 'auto_increment');

        // is_null field
        $declarationIsNull = $declaration['is_null'];
        // default_value field
        $declarationDefaultValue = $declaration['default'];

        // validate data type
        $declarationType = $declaration['type'];
        $declarationMaxLength = null;


        if (
            $declarationIsNull && // Declaration allow null values
            strlen($var) === 0 // Empty incoming var
        ) {
            return ['success' => true, 'message' => 'El valor cumple todos los parámetros de validación'];
        }

        if (
            ($isAutoIncrement || ($declarationDefaultValue !== '')) &&  // IF DECLARATION FOR VAR IS AUTO_INCREMENT OR HAS DEFAULT VALUE
            (is_null($var) || empty($var) || strlen($var) === 0) //AND VAR COMES EMPTY OR NULL AND DISTINCT OF 0
        ) {
            return ['success' => true, 'message' => 'El valor cumple todos los parámetros de validación'];
        }

        if (
            !$declarationIsNull &&  // In Declaration cant store null values
            empty($declarationDefaultValue) && // Not have default value
            strlen($var) === 0) // Incoming test-value is empty
        {
            return ['success' => false, 'message' => 'El valor no puede ser nulo o quedar vacío'];
        }

        // Check for unique value
        if ($sqlAction !== self::PRE_UPDATE_ACTION) {
            if ($isUnique && $this->validateUniqueValue($this->getMapper($declaration['name']), $var) !== true) {
                return ['success' => false, 'message' => 'El valor debe ser único, el valor actual ya se encuentra registrado'];
            }
        }

        // check if declarationType has ( char and do substr
        if (stripos($declarationType, '(')) {

            $declarationTypeData = explode('/', str_replace(['(', ')'], '/', $declarationType));

            $declarationType = $declarationTypeData[0];
            $declarationMaxLength = $declarationTypeData[1];
        }

        // Check for variable type
        switch ($declarationType) {

            case 'int':
            case 'bit':
            case 'tinyint':
            case 'bool':
            case 'boolean':
            case 'smallint':
            case 'mediumint':
            case 'integer':
            case 'bigint':
            case 'year':
                if (!is_int((int) $var)) {
                    return ['success' => false, 'message' => 'El valor debe ser un entero'];
                }
                break;

            case 'float':
            case 'decimal':
            case 'dec':
                if (!is_float((float) $var)) {
                    return ['success' => false, 'message' => 'El valor debe ser un float o decimal'];
                }
                break;

            case 'double':
                if (!is_double((double) $var)) {
                    return ['success' => false, 'message' => 'El valor debe ser un float o decimal'];
                }
                break;

            case 'binary':
            case 'blob':
            case 'char':
            case 'enum':
            case 'mediumtext':
            case 'mediumblob':
            case 'longtext':
            case 'longblob':
            case 'set':
            case 'text':
            case 'tinyblob':
            case 'tinytext':
            case 'varbinary':
            case 'varchar':

            case 'time':
            case 'date':
            case 'datetime':
            case 'timestamp':

                if (!is_string($var)) {
                    return ['success' => false, 'message' => 'El valor debe ser una cadena de texto'];
                }

                break;
        }

        $typeAllowedValues = [];

        // Check for variable length
        if ($declarationMaxLength !== null) {

            if (stripos($declarationMaxLength, ',')) {
                $typeAllowedValues = explode(',', str_replace(["'", '"'], '', $declarationMaxLength));
            }

            // Check for enum options validation
            if ($declarationType === 'enum') {
                if (!in_array($var, $typeAllowedValues)) {
                    return ['success' => false, 'message' => 'El valor no se encuentra entre las opciones enum especificadas'];
                }

            } else if ($declarationType === 'set') {

                $words = explode(' ', $var);

                if (count($words) > 0) {
                    foreach ($words as $word) {
                        if (!in_array($word, $typeAllowedValues)) {
                            return ['success' => false, 'message' => 'El valor no se encuentra entre las opciones set especificadas'];
                        }
                    }
                }

            } else if (count($typeAllowedValues) == 2 && in_array($declarationType, ['float', 'double', 'decimal', 'dec'])) {

                // check if variable in range (min, max)
                $minValue = $typeAllowedValues[0];
                $maxValue = $typeAllowedValues[1];

                switch ($declarationType) {

                    case 'float':
                    case 'double':
                    case 'decimal':
                    case 'dec':

                        $length = (int) strlen(str_replace('.', '', $var));
                        $afterPointDigits = (int) strlen(substr(strrchr($var, "."), 1));

                        if ((int) $minValue !== $length) {
                            // check for entire num length match
                            return ['success' => false, 'message' => 'El valor completo excede el límite de caracteres'];
                        }

                        if ((int) $maxValue !== $afterPointDigits) {
                            // check for decimal part length match
                            return ['success' => false, 'message' => 'El valor decimal excede el límite de caracteres'];
                        }

                        break;

                }

                // Check for length validation
            } else if (
                !$isAutoIncrement &&
                ($declarationMaxLength !== '' && strtoupper($declarationMaxLength) !== 'MAX') &&
                (strlen($var) > $declarationMaxLength)
            ) {
                return ['success' => false, 'message' => 'El valor excede el límite de caracteres'];
            }
        }

        if (!$declarationIsNull && $declarationType === 'year') {
            if (strlen($var) !== 4) {
                return ['success' => false, 'message' => 'El valor debe ser del tipo año (Formato YYYY con números)'];
            }
        }

        if (!$declarationIsNull && ($declarationType === 'datetime' || $declarationType === 'timestamp')) {

            $allowedFormat = 'Y-m-d H:i:s';
            $d = \DateTime::createFromFormat($allowedFormat, $var);

            if (!($d && $d->format($allowedFormat) === $var)) {
                return ['success' => false, 'message' => 'El valor debe ser del tipo Fecha - Hora (YYYY-MM-DD hh:mm:ss)'];
            }
        }

        return ['success' => true, 'message' => 'El valor cumple todos los parámetros de validación'];
    }

    public function validateFields($sqlAction = null) : bool
    {
        $errors = [];

        foreach ($this->validationRules as $varName => $validationRule) {
            $validationResult = $this->validateField($validationRule, $this->$varName, $sqlAction);
            if (!$validationResult['success']) {
                array_push($errors, $varName . ' => "' . $this->$varName . '"; ' . $validationResult['message']);
            }
        }

        $this->validationErrors = $errors;

        return empty($errors);
    }

    private function validateUniqueValue($fieldName, $value) : bool
    {
        $result = $this->getOneByKey($fieldName, $value);
        return empty($result);
    }
}