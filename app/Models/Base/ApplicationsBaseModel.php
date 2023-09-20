<?php

namespace App\Models\Base;



class ApplicationsBaseModel extends BaseModel {



	// Auto-generated file.
	// Please don´t modify this file. 
	// All changes will be erased in the next CLI models::generate command launch
	// Use App\Models\ApplicationsModel.php file instead to add your custom model methods


	protected $table = 'applications';
	protected $primaryKey = 'id';

	protected $returnType = 'array';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['id', 'unique_id', 'app_name', 'url', 'callback_url', 'api_key', 'created_at', 'updated_at', 'deleted_at'];

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $injectForeignTablesDependencies = false;


	protected $id;
	protected $uniqueId;
	protected $appName;
	protected $url;
	protected $callbackUrl;
	protected $apiKey;
	protected $createdAt;
	protected $updatedAt;
	protected $deletedAt;


	protected $mapper = [
		'id' => 'id',
		'uniqueId' => 'unique_id',
		'appName' => 'app_name',
		'url' => 'url',
		'callbackUrl' => 'callback_url',
		'apiKey' => 'api_key',
		'createdAt' => 'created_at',
		'updatedAt' => 'updated_at',
		'deletedAt' => 'deleted_at',
	];

	public function getMapper($key = null)
	{
		return isset($key) ? (isset($this->mapper[$key]) ? $this->mapper[$key] : null) : $this->mapper;
	}


	protected $tableForeignRelations = [
	];

	public function getTableForeignRelations($key = null)
	{
		return isset($key) ? (isset($this->tableForeignRelations[$key]) ? $this->tableForeignRelations[$key] : null) : $this->tableForeignRelations;
	}


	protected $validationRules = [
		'id' => [
			'name' => "id",
			'type' => "int(11)",
			'is_null' => false,
			'key' => 'PRI',
			'default' => '',
			'extra' => 'auto_increment'
		],
		'uniqueId' => [
			'name' => "uniqueId",
			'type' => "varchar(96)",
			'is_null' => false,
			'key' => 'UNI',
			'default' => '',
			'extra' => ''
		],
		'appName' => [
			'name' => "appName",
			'type' => "varchar(64)",
			'is_null' => false,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
		'url' => [
			'name' => "url",
			'type' => "varchar(96)",
			'is_null' => false,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
		'callbackUrl' => [
			'name' => "callbackUrl",
			'type' => "varchar(128)",
			'is_null' => false,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
		'apiKey' => [
			'name' => "apiKey",
			'type' => "varchar(96)",
			'is_null' => false,
			'key' => 'UNI',
			'default' => '',
			'extra' => ''
		],
		'createdAt' => [
			'name' => "createdAt",
			'type' => "timestamp",
			'is_null' => false,
			'key' => '',
			'default' => 'current_timestamp()',
			'extra' => ''
		],
		'updatedAt' => [
			'name' => "updatedAt",
			'type' => "datetime",
			'is_null' => true,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
		'deletedAt' => [
			'name' => "deletedAt",
			'type' => "datetime",
			'is_null' => true,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
	];
	

	public function getPrimaryKeyValue()
	{
		return $this->id;
	}


	public function getId()
	{
		return $this->id;
	}

	public function getUniqueId()
	{
		return $this->uniqueId;
	}

	public function getAppName()
	{
		return $this->appName;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function getCallbackUrl()
	{
		return $this->callbackUrl;
	}

	public function getApiKey()
	{
		return $this->apiKey;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public function getDeletedAt()
	{
		return $this->deletedAt;
	}


	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function setUniqueId($uniqueId)
	{
		$this->uniqueId = $uniqueId;
		return $this;
	}

	public function setAppName($appName)
	{
		$this->appName = $appName;
		return $this;
	}

	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	public function setCallbackUrl($callbackUrl)
	{
		$this->callbackUrl = $callbackUrl;
		return $this;
	}

	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
		return $this;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	public function setDeletedAt($deletedAt)
	{
		$this->deletedAt = $deletedAt;
		return $this;
	}


	public function validateId($id = null)
	{
		return $this->validateField($this->validationRules['id'], $id);
	}

	public function validateUniqueId($uniqueId = null)
	{
		return $this->validateField($this->validationRules['uniqueId'], $uniqueId);
	}

	public function validateAppName($appName = null)
	{
		return $this->validateField($this->validationRules['appName'], $appName);
	}

	public function validateUrl($url = null)
	{
		return $this->validateField($this->validationRules['url'], $url);
	}

	public function validateCallbackUrl($callbackUrl = null)
	{
		return $this->validateField($this->validationRules['callbackUrl'], $callbackUrl);
	}

	public function validateApiKey($apiKey = null)
	{
		return $this->validateField($this->validationRules['apiKey'], $apiKey);
	}

	public function validateCreatedAt($createdAt = null)
	{
		return $this->validateField($this->validationRules['createdAt'], $createdAt);
	}

	public function validateUpdatedAt($updatedAt = null)
	{
		return $this->validateField($this->validationRules['updatedAt'], $updatedAt);
	}

	public function validateDeletedAt($deletedAt = null)
	{
		return $this->validateField($this->validationRules['deletedAt'], $deletedAt);
	}


}
