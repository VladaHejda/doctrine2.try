<?php

/**
 * @Entity @Table(name="products")
 **/
class Product
{

	/** @Id @Column(type="integer") @GeneratedValue **/
	protected $id;

	/** @Column(type="string") **/
	protected $name;

	/** @Column(type="float") **/
	protected $price;

	/** @Column(type="text") **/
	protected $description;


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


	public function getDescription()
	{
		return $this->description;
	}


	public function setName($name)
	{
		$this->name = $name;
	}


	public function setPrice($price)
	{
		$this->price = $price;
	}


	public function setDescription($description)
	{
		$this->description = $description;
	}
}
