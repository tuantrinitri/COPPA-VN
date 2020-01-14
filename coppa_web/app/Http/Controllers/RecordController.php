<?php

namespace App\Http\Controllers;

use App\Record;
use App\Http\Requests\RecordRequest;

class RecordController extends Controller
{
    /**
     * Edit info record
     *
     * @param [int] $id
     * @param Record $mRecord
     * @return void
     */
    public function getEdit($id, Record $mRecord)
    {
        $record = $mRecord->find($id);
        if ($record) {
            $record = $record->toArray();
            $data = [
                'record' => $record
            ];
            return view('record.edit', $data);
        }
        return redirect()->route('list-statistic')->with(['flashDataDanger' => 'Không tìm thấy để sửa!']);
    }

    /**
     * submit to save info record
     *
     * @param [int] $id
     * @param RecordRequest $request
     * @param Record $mRecord
     * @return void
     */
    public function postEdit($id, RecordRequest $request, Record $mRecord)
    {
        $data = $request->except('_token');

        try {
            $record = $mRecord->find($id);
            $record->fill($data);
            $record->save();
            return redirect()->route('list-statistic')->with(['flashDataSuccess' => 'Update successful!']);
        } catch (Exception $e) {
            return redirect()->route('list-statistic')->with(['flashDataDanger' => 'Error!']);
        }
    }

    /**
     * delete a record
     *
     * @param [int] $id
     * @param Record $mRecord
     * @return void
     */
    public function getDelete($id, Record $mRecord)
    {
        $record = $mRecord->find($id);
        $record->delete();
        return redirect()->route('list-statistic')->with(['flashDataSuccess' => 'Delete successful!']);
    }
}