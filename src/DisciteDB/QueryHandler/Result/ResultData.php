<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;
use DisciteDB\Tables\BaseTable;
use mysqli;
use mysqli_result;

class ResultData extends AbstractResult implements Result
{
    protected string $query;

    protected mysqli_result|bool $rawResult;

    protected mixed $result;

    protected mixed $resultData = null;

    protected mixed $resultRows;

    protected mysqli $connection;

    protected Operators $operator;

    protected Database $database;
    
    public function __construct(string $query, mysqli $connection, Operators $operator, Database $database)
    {
        $this->query = $query;
        $this->connection = $connection;
        $this->operator = $operator;
        $this->database = $database;

        $this->executeQuery();
        $this->processResult();
    }

    public function __destruct()
    {
        if ($this->rawResult instanceof mysqli_result) {
            mysqli_free_result($this->rawResult);
        }
    }

    /**
     * Exécute la requête SQL.
     */
    private function executeQuery() : void
    {
        try 
        {
            $this->rawResult = @mysqli_query($this->connection, $this->query);
        } 
        catch (\Exception $e) 
        {
            $this->rawResult = false;
        }
    }

    /**
     * Traite le résultat brut selon le type d'opération.
     */
    private function processResult() : void
    {
        if($this->rawResult instanceof mysqli_result)
        {
            $this->handleRowNumber();
            $this->handleSuccess();
        } 
        elseif($this->rawResult === true)
        {
            $this->handleRowNumber();
            $this->handleSuccessNoResult();
        }
        else
        {
            $this->handleError();
        }
    }

    private function handleRowNumber() : void
    {
        
        $this->resultRows = (is_bool($this->rawResult)) ? 1 : mysqli_num_rows($this->rawResult);
    }

    /**
     * Gère le cas où la requête retourne un jeu de résultats (SELECT).
     */
    public function handleNewResult(mixed $uuid, BaseTable $table) : void
    {
        $_uuid = match(true)
        {
            is_array($uuid) => $uuid,
            is_int($uuid) || is_string($uuid) => [($table->getIndexKey()->getName() ?? $table->getIndexKey()->getAlias()) => $uuid],
            default => null,
        };

        if(!$_uuid) return;

        $_manager = new QueryManager($this->database);
        $_manager->setTable($table);
        $_manager->setConnection($this->connection);
        $_manager->setOperator(Operators::Retrieve);
        $_manager->setArgs([]);
        $_manager->setUuid($_uuid);

        $this->resultData = ($_manager->makeQuery())->fetchAll();
    }

    /**
     * Gère le cas où la requête réussit sans retourner de résultats (INSERT, UPDATE, DELETE).
     */
    private function handleSuccess() : void
    {
        $this->resultData = match ($this->operator) {
            Operators::CountAll => array_values(mysqli_fetch_row($this->rawResult))[0],
            default => null,
        };
    }

    /**
     * Gère le cas où la requête réussit sans retourner de résultats (INSERT, UPDATE, DELETE).
     */
    private function handleSuccessNoResult() : void
    {
        $this->resultData = match ($this->operator) {
            Operators::Delete => ['deleted' => true],
            default => [],
        };
    }

    /**
     * Gère les erreurs SQL.
     */
    private function handleError(): void
    {
        $this->resultData = [];
        $this->resultRows = 0;
        $this->exceptionText = mysqli_error($this->connection);
        $this->exceptionCode = mysqli_errno($this->connection);
    }

    
    
    /**
     * Retourne les données finales du résultat.
     */
    public function getResult(): mixed
    {
        return $this->resultData ?? null;
    }
    
    /**
     * Retourne les données finales du résultat.
     */
    public function getQuery(): string
    {
        return $this->query ?? null;
    }
    
    /**
     * Retourne les données finales du résultat.
     */
    public function getResultAll(): array
    {
        return mysqli_fetch_all($this->rawResult, MYSQLI_ASSOC);
    }
    
    /**
     * Retourne les données finales du résultat.
     */
    public function getResultNext(): ?array
    {
        return mysqli_fetch_assoc($this->rawResult);
    }

    /**
     * Retourne les éventuelles erreurs rencontrées.
     */
    public function getResulRows(): mixed
    {
        return $this->resultRows;
    }



    /**
     * Indique si la requête a échoué.
     */
    public function hasError(): bool
    {
        return $this->exceptionText !== null;
    }

    /**
     * Indique si le résultat contient des données exploitables.
     */
    public function hasData(): bool
    {
        return !empty($this->resultData);
    }

    /**
     * Retourne la requête brute (utile pour le debug).
     */
    public function getRawQuery(): string
    {
        return $this->query;
    }

}

?>