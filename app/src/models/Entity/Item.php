<?php

namespace Up\models\Entity;

class Item
{
	private $id;
	private $name;
	private $price;
	private $shortDesc;
	private $fullDesc;
	private $creationDate;
	private $editingDate;
	private $sortOrder;
	private $additionalCharacteristics;

	public function __construct(
		$id, $name, $price, $shortDesc, $fullDesc, $creationDate, $editingDate, $sortOrder, $additionalCharacteristics)
	{
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		$this->shortDesc = $shortDesc;
		$this->fullDesc = $fullDesc;
		$this->creationDate = $creationDate;
		$this->editingDate = $editingDate;
		$this->sortOrder = $sortOrder;
		$this->additionalCharacteristics = $additionalCharacteristics;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getShortDesc()
	{
		return $this->shortDesc;
	}

	public function getFullDesc()
	{
		return $this->fullDesc;
	}

	public function getCreationDate()
	{
		return $this->creationDate;
	}

	public function getEditingDate()
	{
		return $this->editingDate;
	}

	public function getSortOrder()
	{
		return $this->sortOrder;
	}

	/**
	 * @return array
	 */
	public function getAdditionalCharacteristics()
	{
		return $this->additionalCharacteristics;
	}

	public function setId($newId)
	{
		$this->id = $newId;
	}

	public function setName($newName)
	{
		$this->id = $newName;
	}

	public function setPrice($newPrice)
	{
		$this->id = $newPrice;
	}

	public function setShortDesc($newShortDesc)
	{
		$this->id = $newShortDesc;
	}

	public function setFullDesc($newFullDesc)
	{
		$this->id = $newFullDesc;
	}

	public function setCreatingDate($newCreatingDate)
	{
		$this->id = $newCreatingDate;
	}

	public function setEditingDate($newEditingDate)
	{
		$this->id = $newEditingDate;
	}

	public function setSortOrder($newSortOrder)
	{
		$this->id = $newSortOrder;
	}
}