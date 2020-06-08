<?php

namespace App\Repositories;

use App\Table;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class TableRepository.
 */
class TableRepository extends BaseRepository
{
    public $status = 200;

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return  Table::class;
    }

    public function index()
    {
        return Table::all();
    }

    public function store($request)
    {
        return Table::create([
            'capacity' => $request['capacity'],
            'status' => $request['status']
        ]);
    }

    public function update($request, $table)
    {
        $table->capacity = $request['capacity'];
        $table->status = $request['status'];

        $table->save();

        return $table;
    }

    public function destroy($table)
    {
        return $table->delete();
    }
}
