<?php

require 'bootstrap.php';

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

echo '<h2>All products:</h2>';
foreach ($products as $product) {
	echo sprintf("%s<br>\n", $product->getName());
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	echo "<h2>Product #$id:</h2>";
	$product = $entityManager->find('Product', $id);

	if (!$product) {
		echo '<p>no product</p>';

	} else {
		if (isset($_POST['name'])) {
			$newName = $_POST['name'];
			$product->setName($newName);
			$entityManager->flush();
		}

		echo "<p>name: " . $product->getName() . " , price: " . $product->getPrice() . "</p>";
	}

	?>
<form method="post">
	<input name="name" value="<?=$product->getName(); ?>">
	<input type="submit" value="change">
</form>
	<?php
}
