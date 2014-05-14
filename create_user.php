<?php
// call create_user.php user_name

require_once "bootstrap.php";

$name = $argv[1];

$user = new User();
$user->setName($name);

$entityManager->persist($user);
$entityManager->flush();

echo "Created User with ID " . $user->getId() . "\n";
