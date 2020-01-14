<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Trip;
use App\Captain;
use App\Fish;
use File;

class TripController extends Controller
{
    /**
     * get list trips
     *
     * @param Trip $mTrip
     * @return void
     */
    public function getList(Trip $mTrip)
    {
        $listTrip = $mTrip->orderBy('id', 'desc')->get();

        foreach ($listTrip as $k => $trip) {
            $listTrip[$k]['captain'] = $trip->captains()->get()->first()->toArray();
            $listTrip[$k]['num_record'] = $trip->records()->count();
        }

        $data['listTrip'] = $listTrip;

        return view('trip.list', $data);
    }

    /**
     * view detail a trip
     *
     * @param [int] $id
     * @param Captain $mCaptain
     * @param Trip $mTrip
     * @param Fish $mFish
     * @return void
     */
    public function getDetail($id, Captain $mCaptain, Trip $mTrip, Fish $mFish)
    {
        $trip = $mTrip->find($id);
        if ($trip) {
            $captain = $trip->captains()->get()->first();
            $listRecord = $trip->records()->orderBy('catched_at', 'asc')->get()->toArray();

            if ($listRecord) {
                foreach ($listRecord as $k => $record) {
                    $listRecord[$k]['fish'] = $mFish->find($record['fish_id']);
                }
            }

            $data['captain'] = $captain->toArray();
            $data['listRecord'] = $listRecord;

            $listTrip = $captain->trips()->get()->toArray();
            $num_record = 0;
            foreach ($listTrip as $itrip) {
                $num_record += $mTrip->find($itrip['id'])->records()->count();
            }

            $data['captain_info'] = [
                'num_trip' => $captain->trips()->count(),
                'num_record' => $num_record
            ];

            return view('trip.detail', $data);
        }

        return abort(404);
    }

    /**
     * delete a trip
     *
     * @param [int] $id
     * @param Trip $mTrip
     * @return void
     */
    public function getDelete($id, Trip $mTrip)
    {
        $trip = $mTrip->find($id);
        $listRecord = $trip->records()->get();
        if ($listRecord) {
            foreach ($listRecord as $record) {
                $listImg = json_decode($record['images']);
                foreach ($listImg as $img) {
                    if (File::exists(public_path() . '/data_sync/' . $img)) {
                        File::delete(public_path() . '/data_sync/' . $img);
                    }
                }
                $record->delete();
            }
        }
        $trip->captains()->detach();
        $trip->delete();

        return redirect()->route('list-trip')->with(['flashDataSuccess' => 'Delete successful!']);
    }
}