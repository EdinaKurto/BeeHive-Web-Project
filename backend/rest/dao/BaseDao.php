<?php
require_once __DIR__ . '/../../config.php';


class BaseDao{
    protected $connection;
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->connection = new PDO("mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . ";charset=utf8;port=" . Config::DB_PORT(), Config::DB_USER(),  Config::DB_PASSWORD(), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            print_r($e);
            throw $e;
        }
    }

    protected function query($query, $params) {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params) {
        $results = $this->query($query, $params);
        return reset($results);
    }

    protected function execute($query, $params) {
        $prepared_statement = $this->connection->prepare($query);
        if ($params) {
            foreach ($params as $key => $param) {
                $prepared_statement->bindValue($key, $param);
            }
        }
        $prepared_statement->execute();
        return $prepared_statement;
    }

    public function insert($table, $entity) {
        try {
            $query = "INSERT INTO {$table} (";
            foreach ($entity as $column => $value) {
                $query .= $column . ", ";
            }

            $query = rtrim($query, ", ") . ") VALUES (";

            foreach ($entity as $column => $value) {
                $query .= ":" . $column . ", ";
            }

            $query = rtrim($query, ", ") . ")";

            $stmt = $this->connection->prepare($query);
            $stmt->execute($entity);

            $entity['user_id'] = $this->connection->lastInsertId();

            return $entity;
        } catch (PDOException $e) {
            error_log("Insert error: " . $e->getMessage());
            return false;
        }
    }

   public function update($table, $id, $entity, $id_column = "id")
    {
        $id = (int) $id;

        if (empty($entity)) {
            throw new InvalidArgumentException("Updated data cannot be empty.");
        }

        $query = "UPDATE `$table` SET ";
        $fields = [];
        foreach ($entity as $name => $value) {
            $fields[] = "`$name` = :$name";
        }
        $query .= implode(", ", $fields);
        $query .= " WHERE `$id_column` = :id";

        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);

        return $entity;
    }

    public function delete($table, $id, $id_column = "id")
    {
        $id = (int) $id;

        $query = "DELETE FROM `$table` WHERE `$id_column` = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0; // Returns true if a row was deleted, false otherwise
    }


    public function get_by_id($id, $id_column = null) {
        $id_column = $id_column ?? "{$this->table}_id";

        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE {$id_column} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($entity) {
        $columns = implode(", ", array_keys($entity));
        $placeholders = implode(", ", array_map(fn($col) => ":$col", array_keys($entity)));

        $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute($entity);
        return $this->connection->lastInsertId();
    }
}