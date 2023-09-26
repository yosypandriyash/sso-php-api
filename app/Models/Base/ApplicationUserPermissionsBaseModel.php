<?php

namespace App\Models\Base;



class ApplicationUserPermissionsBaseModel extends BaseModel {



	// Auto-generated file.
	// Please don´t modify this file. 
	// All changes will be erased in the next CLI models::generate command launch
	// Use App\Models\ApplicationUserPermissionsModel.php file instead to add your custom model methods


	protected $table = 'application_user_permissions';
	protected $primaryKey = 'id';

	protected $returnType = 'array';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['id', 'unique_id', 'user_id', 'application_permission_id', 'is_granted', 'created_at', 'updated_at', 'deleted_at'];

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $injectForeignTablesDependencies = false;


	protected $id;
	protected $uniqueId;
	protected $userId;
	protected $applicationPermissionId;
	protected $isGranted;
	protected $createdAt;
	protected $updatedAt;
	protected $deletedAt;


	protected $mapper = [
		'id' => 'id',
		'uniqueId' => 'unique_id',
		'userId' => 'user_id',
		'applicationPermissionId' => 'application_permission_id',
		'isGranted' => 'is_granted',
		'createdAt' => 'created_at',
		'updatedAt' => 'updated_at',
		'deletedAt' => 'deleted_at',
	];

	public function getMapper($key = null)
	{
		return isset($key) ? (isset($this->mapper[$key]) ? $this->mapper[$key] : null) : $this->mapper;
	}


	protected $tableForeignRelations = [
		'userId' => 'UsersModel.id',
		'applicationPermissionId' => 'ApplicationPermissionsModel.id',
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
		'userId' => [
			'name' => "userId",
			'type' => "int(11)",
			'is_null' => false,
			'key' => 'MUL',
			'default' => '',
			'extra' => ''
		],
		'applicationPermissionId' => [
			'name' => "applicationPermissionId",
			'type' => "int(11)",
			'is_null' => false,
			'key' => 'MUL',
			'default' => '',
			'extra' => ''
		],
		'isGranted' => [
			'name' => "isGranted",
			'type' => "tinyint(1)",
			'is_null' => false,
			'key' => '',
			'default' => '1',
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

	public function getUserId()
	{
		return $this->userId;
	}

	public function getApplicationPermissionId()
	{
		return $this->applicationPermissionId;
	}

	public function getIsGranted()
	{
		return $this->isGranted;
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

	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	public function setApplicationPermissionId($applicationPermissionId)
	{
		$this->applicationPermissionId = $applicationPermissionId;
		return $this;
	}

	public function setIsGranted($isGranted)
	{
		$this->isGranted = $isGranted;
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


}
