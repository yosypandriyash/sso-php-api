<?php

namespace App\Models\Base;



class ApplicationUsersBaseModel extends BaseModel {



	// Auto-generated file.
	// Please don´t modify this file. 
	// All changes will be erased in the next CLI models::generate command launch
	// Use App\Models\ApplicationUsersModel.php file instead to add your custom model methods


	protected $table = 'application_users';
	protected $primaryKey = 'id';

	protected $returnType = 'array';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['id', 'unique_id', 'application_id', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $injectForeignTablesDependencies = false;


	protected $id;
	protected $uniqueId;
	protected $applicationId;
	protected $userId;
	protected $createdAt;
	protected $updatedAt;
	protected $deletedAt;


	protected $mapper = [
		'id' => 'id',
		'uniqueId' => 'unique_id',
		'applicationId' => 'application_id',
		'userId' => 'user_id',
		'createdAt' => 'created_at',
		'updatedAt' => 'updated_at',
		'deletedAt' => 'deleted_at',
	];

	public function getMapper($key = null)
	{
		return isset($key) ? (isset($this->mapper[$key]) ? $this->mapper[$key] : null) : $this->mapper;
	}


	protected $tableForeignRelations = [
		'applicationId' => 'ApplicationsModel.id',
		'userId' => 'UsersModel.id',
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
		'applicationId' => [
			'name' => "applicationId",
			'type' => "int(11)",
			'is_null' => false,
			'key' => 'MUL',
			'default' => '',
			'extra' => ''
		],
		'userId' => [
			'name' => "userId",
			'type' => "int(11)",
			'is_null' => false,
			'key' => 'MUL',
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

	public function getApplicationId()
	{
		return $this->applicationId;
	}

	public function getUserId()
	{
		return $this->userId;
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

	public function setApplicationId($applicationId)
	{
		$this->applicationId = $applicationId;
		return $this;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
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

	public function validateApplicationId($applicationId = null)
	{
		return $this->validateField($this->validationRules['applicationId'], $applicationId);
	}

	public function validateUserId($userId = null)
	{
		return $this->validateField($this->validationRules['userId'], $userId);
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
