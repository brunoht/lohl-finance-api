<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class Query
{
    protected $params = [];

    public function param(string $key, $value) : self
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function params(array $params) : self
    {
        foreach ($params as $key => $value)
        {
            $this->param($key, $value);
        }
        return $this;
    }

    protected function use(string $key)
    {
        return $this->params[$key] ?? null;
    }

    protected function query() : Builder
    {
        return new Builder();
    }

    public function run() : Builder
    {
        return $this->query();
    }

    public function get(array $fields = []) : Collection
    {
        return (count($fields) > 0) ?
            $this->run()->get($fields) :
            $this->run()->get();
    }

    public function toSql() : string
    {
        return $this->run()->toSql();
    }

    public function first(array $fields = [])
    {
        return (count($fields) > 0) ?
            $this->run()->first($fields) :
            $this->run()->first();
    }

    public function toArray(array $fields = []) : array
    {
        return (count($fields) > 0) ?
            $this->run()->get($fields)->toArray() :
            $this->run()->get()->toArray();
    }

    public function currentMonth() : string
    {
        $month = Carbon::now()->month;
        $month = str_pad($month, 2, '0', STR_PAD_LEFT); // format month to two digits
        return $month;
    }

    public function currentYear() : string
    {
        return Carbon::now()->year;
    }

    public function currentDay() : string
    {
        $day = Carbon::now()->day;
        $day = str_pad($day, 2, '0', STR_PAD_LEFT); // format month to two digits
        return $day;
    }

    public function uuid() : string
    {
        return Uuid::uuid4()->toString();
    }

    protected function dbDate($day = null, $month = null, $year = null) : string
    {
        $day = $day ?? $this->currentDay();
        $month = $month ?? $this->currentMonth();
        $year = $year ?? $this->currentYear();
        return "$year-$month-$day";
    }

    protected function brDate($day = null, $month = null, $year = null) : string
    {
        $day = $day ?? $this->currentDay();
        $month = $month ?? $this->currentMonth();
        $year = $year ?? $this->currentYear();
        return "$day/$month/$year";
    }
}
