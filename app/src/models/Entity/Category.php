<?php

namespace Up\models\Entity;

class Category
{
	private $id;
	private $name;
    private $parent;
    private $alias;

	public function __construct($id, $name, $parent, $alias)
	{
		$this->id = $id;
		$this->name = $name;
        $this->parent = $parent;
        $this->alias = $alias;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setId($newId)
	{
		$this->name = $newId;
	}

	public function setName($newName)
	{
		$this->name = $newName;
	}

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias): void
    {
        $this->alias = $alias;
    }

}