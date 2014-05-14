<?php

require 'bootstrap.php';

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

?>
<!doctype html>
<meta charset="utf-8">
<?php




echo '<h2>All products:</h2><table style="border:#000 1px solid;">';
foreach ($products as $product) {
	echo '<tr><td>';
	echo $product->getId();
	echo '</td><td>';
	echo iconv('cp1250', 'utf-8', $product->getName());
	echo '</td><td>';
	echo iconv('cp1250', 'utf-8', $product->getDescription());
	echo '</td></tr>';
}
echo '</table>';




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
	<input name="name" value="<?=$product ? $product->getName() : ''; ?>">
	<input type="submit" value="change">
</form>
	<?php
}




if (isset($_POST['create'])) {
	function createBug($entityManager){
		$description = $_POST['description'];
		$reporter = $entityManager->find('User', $_POST['reporterId']);
		if (!$reporter) {
			echo '<p>neexistujcí userus</p>';
			return;
		}
		$productsIds = explode(',', $_POST['productsIds']);

		$bug = new Bug;
		$bug->setDescription($description);
		$bug->setCreated(new \DateTime);
		$bug->setReporter($reporter);
		$bug->setStatus('OPEN');

		foreach ($productsIds as $productId) {
			$productId = trim($productId);
			$product = $entityManager->find('Product', $productId);
			if (!$product) {
				echo "<p>neexistujcí produktus $productId</p>";
				return;
			}
			$bug->assignToProduct($product);
		}

		$entityManager->persist($bug);
		$entityManager->flush();
		echo "<p>Byl kreatovanej bugís '$description'</p>";
	}
	createBug($entityManager);
}
?>
<h2>Urobiť nové buga:</h2>
<form method="post">
	<p>Popís buga: <input name="description" value="<?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?>" size="50"></p>
	<p>ÍDé tvojo: <input name="reporterId" value="<?php echo isset($_POST['reporterId']) ? $_POST['reporterId'] : ''; ?>"></p>
	<p>ÍDéčka produktóv, na kterejch ty bugy sou, vodděl čarou: <input name="productsIds" value="<?php echo isset($_POST['productsIds']) ? $_POST['productsIds'] : ''; ?>" size="50"></p>
	<p><input type="submit" name="create" value="create"></p>
</form>

<?php

$dql = "SELECT b, e, r FROM Bug b LEFT JOIN b.engineer e JOIN b.reporter r ".
	"WHERE r.id = ?1 ORDER BY b.created DESC";

$query = $entityManager->createQuery($dql)->setMaxResults(5)->setParameter(1, isset($_GET['id']) ? $_GET['id'] : 1);
$bugs = $query->getResult();

echo '<table>';
foreach ($bugs as $bug) {
	echo '<tr><td>' . $bug->getCreated()->format('d.m.Y')
		. '<td>' . $bug->getDescription() . '</td>'
		. '<td>' . $bug->getReporter()->getName() . '</td>'
		. '<td>' . ($bug->getEngineer() ? $bug->getEngineer()->getName() : '-') . '</td><td>Products:<ul>';
	foreach ($bug->getProducts() as $product) {
		echo '<li>' . $product->getName(). "</li>";
	}
	echo '</ul></tr>';
}
echo '</table>';





$dql = "SELECT count(b.id) FROM Bug b";
$count = $entityManager->createQuery($dql)->getSingleScalarResult();
echo "<h2>Count of bugs: $count</h2>";
