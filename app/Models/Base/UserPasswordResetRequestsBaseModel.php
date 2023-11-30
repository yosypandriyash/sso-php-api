<?php

namespace App\Models\Base;



class UserPasswordResetRequestsBaseModel extends BaseModel {



	// Auto-generated file.
	// Please don´t modify this file. 
	// All changes will be erased in the next CLI models::generate command launch
	// Use App\Models\UserPasswordResetRequestsModel.php file instead to add your custom model methods


	protected $table = 'user_password_reset_requests';
	protected $primaryKey = 'id';

	protected $returnType = 'array';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['id', 'user_id', 'unique_id', 'origin_ip', 'is_active', 'expiration_date', 'created_at', 'updated_at', 'deleted_at'];

	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $injectForeignTablesDependencies = false;


	protected $id;
	protected $userId;
	protected $uniqueId;
	protected $originIp;
	protected $isActive;
	protected $expirationDate;
	protected $createdAt;
	protected $updatedAt;
	protected $deletedAt;


	protected $mapper = [
		'id' => 'id',
		'userId' => 'user_id',
		'uniqueId' => 'unique_id',
		'originIp' => 'origin_ip',
		'isActive' => 'is_active',
		'expirationDate' => 'expiration_date',
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
		'userId' => [
			'name' => "userId",
			'type' => "int(11)",
			'is_null' => false,
			'key' => 'MUL',
			'default' => '',
			'extra' => ''
		],
		'uniqueId' => [
			'name' => "uniqueId",
			'type' => "varchar(96)",
			'is_null' => false,
			'key' => 'UNI',
			'default' => '',
			'extra' => ''
		],
		'originIp' => [
			'name' => "originIp",
			'type' => "varchar(64)",
			'is_null' => false,
			'key' => '',
			'default' => '',
			'extra' => ''
		],
		'isActive' => [
			'name' => "isActive",
			'type' => "tinyint(1)",
			'is_null' => false,
			'key' => '',
			'default' => '0',
			'extra' => ''
		],
		'expirationDate' => [
			'name' => "expirationDate",
			'type' => "datetime",
			'is_null' => false,
			'key' => '',
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

	public function getUserId()
	{
		return $this->userId;
	}

	public function getUniqueId()
	{
		return $this->uniqueId;
	}

	public function getOriginIp()
	{
		return $this->originIp;
	}

	public function getIsActive()
	{
		return $this->isActive;
	}

	public function getExpirationDate()
	{
		return $this->expirationDate;
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

	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	public function setUniqueId($uniqueId)
	{
		$this->uniqueId = $uniqueId;
		return $this;
	}

	public function setOriginIp($originIp)
	{
		$this->originIp = $originIp;
		return $this;
	}

	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
		return $this;
	}

	public function setExpirationDate($expirationDate)
	{
		$this->expirationDate = $expirationDate;
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
