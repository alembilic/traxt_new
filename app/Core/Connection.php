<?php

namespace App\Core;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Doctrine\DBAL\Driver;
use Illuminate\Database\DatabaseTransactionsManager;

/**
 * This class overrides standard doctrine connection. This class send information into Laravel Database
 * transaction manager about open and close transactions to make option `afterCommit` of jobs/listeners/etc. works
 * correctly
 */
class Connection extends DoctrineConnection
{
    private ?DatabaseTransactionsManager $transactionsManager;

    public function __construct(
        array $params,
        Driver $driver,
        ?Configuration $config = null,
        ?EventManager $eventManager = null
    ) {
        parent::__construct($params, $driver, $config, $eventManager);

        if (app()->bound('db.transactions')) {
            $this->transactionsManager = app()->make('db.transactions');
        }
    }

    public function beginTransaction(): bool
    {
        $result = parent::beginTransaction();

        optional($this->transactionsManager)->begin($this->getName(), $this->getTransactionNestingLevel());

        return $result;
    }

    public function commit(): bool
    {
        $result = parent::commit();

        if ($this->getTransactionNestingLevel() === 0) {
            optional($this->transactionsManager)->commit($this->getName());
        }

        return $result;
    }

    public function rollBack(): bool
    {
        $result = parent::rollBack();

        // TODO: Need to investigate need we rollback transaction in case of error in rollback (ex. Connection was lost)

        optional($this->transactionsManager)->rollback($this->getName(), $this->getTransactionNestingLevel());

        return $result;
    }

    private function getName(): string
    {
        return config('doctrine.managers.default.connection');
    }
}
