<?php

namespace App\Http\Controllers\api;

use App\Repositories\TableRepository;
use App\Http\Controllers\Controller;
use App\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $table;

    public function __construct(TableRepository $table)
    {
        $this->table = $table;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = $this->table->index();

        $result = [
            'table' => $table
        ];

        return response()->json($result, $this->table->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = $this->table->store($request);

        $result = [
            'table' => $table
        ];

        return response()->json($result, $this->table->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $table = $this->table->update($request, $table);

        $result = [
            'table' => $table
        ];

        return response()->json($result, $this->table->status, [], JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table = $this->table->destroy($table);

        $result = [
            'table' => $table
        ];

        return response()->json($result, $this->table->status, [], JSON_PRETTY_PRINT);
    }
}
