<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Captain;
use App\Record;
use App\Trip;
use CommonHelper, Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * post caption information to create or update
     *
     * @param Request $request
     * @param Captain $mCaptain
     * @return void
     */
    public function postCaptain(Request $request, Captain $mCaptain)
    {
        $data = $request->all();
        if (!empty($data)) {
            if (isset($data['id']) && $data['id']) {
                $captain = $mCaptain->find($data['id']);
                if ($captain) {
                    $captain->fill($data);
                    $captain->save();

                    $result = [
                        'status' => true,
                        'data' => ['id' => $captain->id],
                        'message' => 'Updated Successful',
                        'data_rq' => $data
                    ];
                } else {
                    unset($data['id']);
                    $captain = new Captain($data);
                    $captain->save();

                    $result = [
                        'status' => true,
                        'data' => ['id' => $captain->id],
                        'message' => 'Add Successful'
                    ];
                }
            } else {
                $captain = $mCaptain->where($data)->get()->first();
                if ($captain) {
                    $result = [
                        'status' => false,
                        'data' => ['id' => $captain->id],
                        'message' => 'Captain existed',
                        'data_rq' => $data
                    ];
                } else {
                    $captain = new Captain($data);
                    $captain->save();

                    $result = [
                        'status' => true,
                        'data' => ['id' => $captain->id],
                        'message' => 'Add Successful',
                        'data_rq' => $data
                    ];
                }
            }

            return response()->json($result);
        }

        $result = [
            'status' => false,
            'data' => ['id' => -1],
            'message' => 'Data empty'
        ];

        return response()->json($result);
    }

    /**
     * post a new record
     *
     * @param Request $request
     * @param Captain $mCaptain
     * @return void
     */
    public function postRecord(Request $request, Captain $mCaptain)
    {
        try {
            $data = $request->all();

            // file_put_contents(public_path('data.txt'), json_encode($data));

            // Check existed trip
            $captain = $mCaptain->find($data['captain_id']);

            $data['trip']['from_date'] = Carbon::createFromFormat('Y-m-d', $data['trip']['from_date'])->format('Y-m-d');
            $data['trip']['to_date'] = Carbon::createFromFormat('Y-m-d', $data['trip']['to_date'])->format('Y-m-d');

            $trip = $captain->trips()->where(['from_date' => $data['trip']['from_date']])->get()->first();
            if (empty($trip)) {
                // Create new trip before add record
                $trip = new Trip($data['trip']);
                $trip->save();
                $trip->captains()->attach($data['captain_id']);
            }

            // Add record
            $record_data = $request->except(['captain_id', 'trip']);

            if ($record_data['fish_id'] == -1) $record_data['fish_id'] = 0;
            $record_data['images'] = json_encode([]);
            $record_data['catched_at'] = date('Y-m-d H:i:s', strtotime($record_data['catched_at'])); //Carbon::createFromFormat('Y/m/d H:i:s', $record_data['catched_at'])->format('Y-m-d H:i:s'); //
            $record = new Record($record_data);
            $record->save();
            $record->trips()->attach($trip->id);

            $result = [
                'status' => true,
                'message' => 'Sync Successful',
                'data' => [
                    'record_id' => $record->id
                ]
            ];

            return response()->json($result);
        } catch (Exception $e) {
            $result = [
                'status' => false,
                'message' => 'Error',
                'data' => $e
            ];

            return response()->json($result);
        }
    }

    /**
     * post image in record
     *
     * @param Request $request
     * @param Record $mRecord
     * @return void
     */
    public function postImage(Request $request, Record $mRecord)
    {
        $data = $request->all();

        $record = $mRecord->find($data['record_id']);

        $arrImages = $record->images;
        $arrImages = json_decode($arrImages);

        // Processing image
        $filename = CommonHelper::saveBase64ToImage($data['base64_content'], $data['record_id'] . '_' . count($arrImages));

        if ($filename) {
            $arrImages[] = $filename;
            // Save to DB
            $record->fill(['images' => json_encode($arrImages)]);
            $record->save();

            // Result
            $result = [
                'status' => true,
                'message' => 'Uploaded Image Successful',
                'data' => [
                    'record_id' => $data['record_id']
                ]
            ];
        } else {
            $result = [
                'status' => false,
                'message' => 'Error When save Image',
                'data' => [
                    'record_id' => $data['record_id']
                ]
            ];
        }

        return response()->json($result);
    }
}