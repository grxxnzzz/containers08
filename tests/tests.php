<?php
require_once __DIR__ . '/testframework.php';

require_once __DIR__ . '/../site/config.php';
require_once __DIR__ . '/../site/modules/database.php';
require_once __DIR__ . '/../site/modules/page.php';

$testFramework = new TestFramework();

// Test 1: Проверка соединения с БД
function testDbConnection() {
    global $config;
    try {
        $db = new Database($config["db"]["path"]);
        return assertExpression($db instanceof Database, "DB connection OK", "DB connection FAIL");
    } catch (Exception $e) {
        return false;
    }
}

// Test 2: Проверка Count()
function testDbCount() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $count = $db->Count("page");
    return assertExpression($count == 3, "Count OK", "Count FAIL");
}

// Test 3: Проверка Create()
function testDbCreate() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $id = $db->Create("page", ["title" => "Test", "content" => "Test Content"]);
    return assertExpression($id > 0, "Create OK", "Create FAIL");
}

// Добавляем тесты
$testFramework->add('Database connection', 'testDbConnection');
$testFramework->add('Count records', 'testDbCount');
$testFramework->add('Create record', 'testDbCreate');

// Запускаем тесты
$testFramework->run();
echo "Result: " . $testFramework->getResult();