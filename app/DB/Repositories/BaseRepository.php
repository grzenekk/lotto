<?php

namespace App\DB\Repositories;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Grammars\PostgresGrammar;

abstract class BaseRepository extends Builder
{
    protected $model;

    public function __construct(QueryBuilder $query)
    {
        parent::__construct(new QueryBuilder(
            app(ConnectionInterface::class),
            new PostgresGrammar()
        ));

        $this->setModel(new $this->model);
    }

    public function setModel(Model $model)
    {
        $self = parent::setModel($model);
        $this->model->registerGlobalScopes($this->withoutGlobalScopes());
        $this->query = $this->model->getQuery();

        return $self;
    }

    public function newQuery()
    {
        $this->setModel(new $this->model);

        return $this;
    }

    public function all()
    {
        return $this->model::all();
    }
}
