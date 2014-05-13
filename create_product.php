<?php
// call create_product.php product_name

require_once "bootstrap.php";

$name = $argv[1];
$price = $argv[2];
$description = $argv[3];

$product = new Product();
$product->setName($name);
$product->setPrice($price);
$product->setDescription($description);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . "\n";
