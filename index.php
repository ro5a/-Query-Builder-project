<?php

class QueryBuilder
{
    private $fields = [];
    private $conditions = [];
    private $from = [];
    public function __construct()
    {
        $this->reset();
    }

    public function __toString(): string
    {
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);
        return 'SELECT ' . implode(', ', $this->fields)
            . ' FROM ' . implode(', ', $this->from)
            . $where;
    }
    public function select(string ...$select): self
    {
        $this->fields = $select;
        return $this;
    }

    public function where(string $where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

   
}
$query = (new QueryBuilder())
->select('email', 'first_name', 'last_name')
->from('user');

$Statement = $pdo->prepare($query);
$Statement->execute();

$users = $Statement->fetchAll(PDO::FETCH_ASSOC);
$query = (new QueryBuilder())
->select('u.email', 'u.first_name', 'u.last_name', 'u.active')
->from('user', 'u')
->where('u.email = :email', 'u.active = :bool');

$Statement = $pdo->prepare($query);
$Statement->execute([
    'email' => 'roor3hakimi@gmail.com', 
    'bool' => 1
    ]
);

$user = $Statement->fetch(PDO::FETCH_ASSOC);
?>
