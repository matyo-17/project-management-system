<?php

namespace App\Lib;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Datatable {
    public string $order_dir, $order_col, $hints;
    public int $offset, $limit, $count;
    public array $filters, $data;
    public Builder $query;

    public function __construct(Request $request) {
        $order = $request->input('order');
        $column = $request->input('columns');
        $search = $request->input('search', []);

        $this->order_dir = $order[0]["dir"];
        $this->order_col = $column[$order[0]["column"]]["data"];
        $this->offset = $request->input('start');
        $this->limit = $request->input('length');
        $this->filters = $request->input('filters', []);
        $this->hints = $search['value'] ?? "";
    }

    public function count(): self {
        $this->count = $this->query->count();
        return $this;
    }

    public function order(): self {
        $this->query->orderBy($this->order_col, $this->order_dir);
        return $this;
    }

    public function paginate(): self {
        $this->query->offset($this->offset)->limit($this->limit);;
        return $this;
    }

    public function result(): self {
        $this->data = $this->query->get()->toArray();
        return $this;
    }

    public function sql(): string {
        return Str::replaceArray('?', $this->query->getBindings(), $this->query->toSql());
    }
}
