<?php

namespace Up\models\Entity;

class Image
{
	private $id;
    private $item_id;
	private $path;


	public function __construct($id, $item_id, $path)
	{
		$this->id = $id;
		$this->item_id = $item_id;
		$this->path = $path;
	}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getItemId()
    {
        return $this->item_id;
    }

    public function setItemId($item_id): void
    {
        $this->item_id = $item_id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }
}