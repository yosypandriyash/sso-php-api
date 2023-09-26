<?php

namespace App\Models\Base;



class ApplicationPermissionsBaseModel extends BaseModel {



	// Auto-generated file.
	// Please don´t modify this file. 
	// All changes will be erased in the next CLI models::generate command launch
	// Use App\Models\ApplicationPermissionsModel.php file instead to add your custom model methods


	protected $table = 'application_permissions';
	protected $primaryKey = 'id';

	protected $returnType = 'array';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['id', 'unique_id', 'permission_name', 'permission_description', 'application_id', 'is_active', 'created_at', 'updated_at', 'deleted_at'];

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $injectForeignTablesDependencies = false;


	protected $id;
	protected $uniqueId;
	protected $permissionName;
	protected $permissionDescription;
	protected $applicationId;
	protected $isActive;
	protected $createdAt;
	protected $updatedAt;
	protected $deletedAt;


	protected $mapper = [
		'id' => 'id',
		'uniqueId' => 'unique_id',
		'permissionName' => 'permission_name',
		'permissionDescription' => 'permission_description',
		'applicationId' => 'application_id',
		'isActive' => 'is_active',
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
		'permissionName' => [
			'name' => "permissionName",
			'type' => "varchar(64)",
			'is_null' => false,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
		'permissionDescription' => [
			'name' => "permissionDescription",
			'type' => "varchar(128)",
			'is_null' => true,
			'key' => '',
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
		'isActive' => [
			'name' => "isActive",
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

	public function getPermissionName()
	{
		return $this->permissionName;
	}

	public function getPermissionDescription()
	{
		return $this->permissionDescription;
	}

	public function getApplicationId()
	{
		return $this->applicationId;
	}

	public function getIsActive()
	{
		return $this->isActive;
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

	public function setPermissionName($permissionName)
	{
		$this->permissionName = $permissionName;
		return $this;
	}

	public function setPermissionDescription($permissionDescription)
	{
		$this->permissionDescription = $permissionDescription;
		return $this;
	}

	public function setApplicationId($applicationId)
	{
		$this->applicationId = $applicationId;
		return $this;
	}

	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
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
