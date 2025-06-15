<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Utilities\ValidateJson;
use mysqli;
use mysqli_result;

class ResultData extends AbstractResult implements Result
{
    protected string $query;

    protected mysqli_result|bool $rawResult;

    protected mixed $result;

    protected mixed $resultData = null;

    protected mixed $resultRows;

    protected QueryManager $queryManager;
    
    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;
        $this->query = $this->queryManager->getQueryBuilder()->createBuild();

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
            $this->rawResult = @mysqli_query($this->queryManager->getConnection(), $this->query);
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
            is_int($uuid) || is_string($uuid) => [($table->getPrimaryKey()->getName() ?? $table->getPrimaryKey()->getAlias()) => $uuid],
            default => null,
        };

        if(!$_uuid) return;

        $_manager = new QueryManager($this->queryManager->getInstance());
        $_manager->setTable($table);
        $_manager->setConnection($this->queryManager->getConnection());
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
        $this->resultData = match ($this->queryManager->getOperator()) {
            Operators::CountAll => intval(array_values(mysqli_fetch_row($this->rawResult))[0]) ?? 0,
            Operators::Count => intval(array_values(mysqli_fetch_row($this->rawResult))[0]) ?? 0,
            default => null,
        };
    }

    /**
     * Gère le cas où la requête réussit sans retourner de résultats (INSERT, UPDATE, DELETE).
     */
    private function handleSuccessNoResult() : void
    {
        $this->resultData = match ($this->queryManager->getOperator()) {
            Operators::Delete => ['deleted' => true],
            Operators::Create => [$this->queryManager->getTable()->getPrimaryKey()->getAlias() => mysqli_insert_id($this->queryManager->getConnection())],
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
        $this->exceptionText = mysqli_error($this->queryManager->getConnection());
        $this->exceptionCode = mysqli_errno($this->queryManager->getConnection());
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

        $rows = mysqli_fetch_all($this->rawResult, MYSQLI_ASSOC);

        return $this->decodeJsonFieldsRecursively($rows);
        
    }

    private function decodeJsonFieldsRecursively(array $rows) : array
    {
        foreach ($rows as $key => &$row) {
            if(is_object($row) || is_array($row))
            {
                foreach ($row as $key => $value) {
                    if (is_string($value) && ValidateJson::isJson($value)) {
                        $row[$key] = json_decode($value, true);
        
                        // Optional: decode sub-fields recursively too
                        if (is_array($row[$key])) {
                            $row[$key] = $this->decodeJsonFieldsRecursively([$row[$key]])[0];
                        }
                    }
                }
            }
            else
            {
                if (is_string($row) && ValidateJson::isJson($row)) {
                    $row = json_decode($row, true);
    
                    // Optional: decode sub-fields recursively too
                    if (is_array($row)) {
                        $row = $this->decodeJsonFieldsRecursively([$row])[0];
                    }
                }
            }
        }
        return $rows;
    }
    
    /**
     * Retourne les données finales du résultat.
     */
    public function getResultNext(): ?array
    {
        $rows = mysqli_fetch_assoc($this->rawResult);

        return $this->decodeJsonFieldsRecursively($rows);
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