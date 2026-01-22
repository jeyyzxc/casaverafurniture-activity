<?php
/**
 * Database Class
 * A reusable "Service" that handles all communication with MySQL.
 * Uses PDO (PHP Data Objects) for security against SQL Injection.
 */

class Database {
    // Properties to hold connection details
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset = 'utf8mb4';
    private $pdo; // The actual connection object

    /**
     * Constructor
     * Automatically connects to the database when you write: $db = new Database();
     */
    public function __construct() {
        // 0. Defensive Check: Ensure config is loaded
        if (!defined('DB_HOST')) {
            throw new Exception("Configuration Error: config.php not loaded. Database constants are missing.");
        }

        // 1. Load credentials from config.php constants
        $this->host     = DB_HOST;
        $this->dbname   = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;

        // 2. Set up the DSN (Data Source Name)
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        // 3. Set options for security and error handling
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw errors (don't stay silent)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Return arrays like ['name' => 'Sofa']
            PDO::ATTR_EMULATE_PREPARES   => false,                // Use real prepared statements (Security)
        ];

        // 4. Attempt the connection
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // Throw exception so it can be caught by the calling script
            throw new Exception("Database Connection Failed: " . $e->getMessage());
        }
    }

    /**
     * Helper: Run a Query
     * Used internally by fetchAll/fetchOne, or for UPDATE/INSERT/DELETE
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Throw exception so add_to_cart.php can catch it and return JSON
            throw new Exception("Query Failed: " . $e->getMessage());
        }
    }

    /**
     * Helper: Get Many Rows
     * Usage: $products = $db->fetchAll("SELECT * FROM products");
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Helper: Get One Row
     * Usage: $user = $db->fetchOne("SELECT * FROM users WHERE id = ?", [1]);
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Helper: Get Last Inserted ID
     * Useful when you just inserted an order and need its ID immediately
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Helper: Get Row Count
     * Useful for checking if a user already exists
     */
    public function rowCount($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    // =========================================================
    // NEW: Transaction Methods (Required for Checkout)
    // =========================================================

    /**
     * Start a Transaction
     * Used when you need to run multiple queries that depend on each other.
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    /**
     * Commit a Transaction
     * Save all changes made during the transaction.
     */
    public function commit() {
        return $this->pdo->commit();
    }

    /**
     * Rollback a Transaction
     * Undo changes if something went wrong.
     */
    public function rollBack() {
        return $this->pdo->rollBack();
    }
}
?>