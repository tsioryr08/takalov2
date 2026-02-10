<?php
class CategoryRepository {
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll(): array
  {
    $table = $this->resolveTable('categorie');
    $objetTable = $this->resolveTable('objet');
    if ($table === null) return [];

    $join = $objetTable ? "LEFT JOIN {$objetTable} o ON o.categorie_id = c.id" : '';
    $sql = "SELECT c.id, c.nom, c.description, COUNT(o.id) AS objets
      FROM {$table} c
      {$join}
      GROUP BY c.id
      ORDER BY c.id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function create(string $nom, string $description): int
  {
    $table = $this->resolveTable('categorie');
    if ($table === null) throw new RuntimeException('categorie table not found');
    $sql = "INSERT INTO {$table} (nom, description) VALUES (:nom, :description)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->execute();
    return (int)$this->pdo->lastInsertId();
  }


  public function update(int $id, string $nom, string $description): bool
  {
    $table = $this->resolveTable('categorie');
    if ($table === null) return false;
    $sql = "UPDATE {$table} SET nom = :nom, description = :description WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function delete(int $id): bool
  {
    $table = $this->resolveTable('categorie');
    if ($table === null) return false;
    $sql = "DELETE FROM {$table} WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  /**
   * Resolve table name for categorie or objet in the current database.
   * Returns the table name (no schema) if it exists in the current DB, otherwise null.
   * @param string $type
   * @return string|null
   */
  private function resolveTable(string $type = 'categorie'): ?string
  {
    $db = $this->pdo->query('SELECT DATABASE()')->fetchColumn();
    if (!$db) return null;
    try {
      $st = $this->pdo->prepare('SELECT 1 FROM information_schema.tables WHERE table_schema = :schema AND table_name = :table LIMIT 1');
      $st->execute([':schema' => $db, ':table' => $type]);
      if ($st->fetchColumn()) return $type;
    } catch (Throwable $e) {
      // ignore
    }
    return null;
  }
}
