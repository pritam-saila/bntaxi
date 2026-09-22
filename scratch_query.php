<?php
$host = '127.0.0.1';
$db   = 'bntaxi';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $stmt = $pdo->query('SELECT * FROM fixed_prices WHERE keywords LIKE "%Gatwick%" OR keywords LIKE "%Brighton%"');
     while ($row = $stmt->fetch())
     {
         echo json_encode($row) . "\n";
     }
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
