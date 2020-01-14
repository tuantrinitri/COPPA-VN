<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, Excel, File;
use App\Captain;
use App\Trip;
use App\Record;
use App\Fish;
use Illuminate\Support\Facades\Input;

class CaptainController extends Controller
{
    /**
     * get list captain
     *
     * @param Captain $mCaptain
     * @return void
     */
    public function getList(Captain $mCaptain)
    {
        if (Auth::user()->level == 1) {
            $listCaptain = $mCaptain->all()->toArray();
            $data = [
                'listCaptain' => $listCaptain
            ];
            return view('captain.list', $data);
        }
        return redirect()->route('home');
    }

    /**
     * view detail captain
     *
     * @param [int] $id
     * @param Captain $mCaptain
     * @param Trip $mTrip
     * @param Fish $mFish
     * @return void
     */
    public function getDetail($id, Captain $mCaptain, Trip $mTrip, Fish $mFish)
    {
        if ($mCaptain->find($id)) {

            $captain = $mCaptain->find($id);
            $listTrip = $captain->trips()->orderBy('from_date', 'desc')->get()->toArray();
            $data['captain'] = $captain->toArray();

            $num_trip = $captain->trips()->count();
            $num_record = 0;
            foreach ($listTrip as $k => $trip) {
                $tmpNum = $mTrip->find($trip['id'])->records()->count();
                $listTrip[$k]['num_record'] = $tmpNum;
                $num_record += $tmpNum;
            }

            $data['captain_info'] = [
                'num_trip' => $captain->trips()->count(),
                'num_record' => $num_record
            ];
            $data['listTrip'] = $listTrip;
            return view('captain.detail', $data);
        } else {
            return abort(404);
        }
    }

    /**
     * download excel captain
     *
     * @param [int] $id
     * @param Captain $mCaptain
     * @return void
     */
    public function downloadExcel($id, Captain $mCaptain)
    {
        if (Auth::user()->level != 1) return redirect()->route('home');

        $captain = $mCaptain->where(['id' => $id])->get()->first();
        // Preparing export excel
        $ext = 'xlsx';

        Excel::create(str_replace('-', '_', str_slug($captain['fullname'])) . '_report_' . date('d.m.Y_H.i', time()), function ($excel) {
            $excel->sheet('Sheet 1', function ($sheet) {
                // Get list records
                $mRecord = new Record();
                $mFish = new Fish();
                $mCaptain = new Captain();
                $listTrip = $mCaptain->where(['id' => intval(request()->id)])->first()->trips()->orderBy('id', 'asc')->get();
                $arrRecord = [];
                $num = 1;
                foreach ($listTrip as $trip) {
                    $listRecord = $trip->records()->orderBy('catched_at', 'asc')->get();
                    if ($listRecord) {
                        foreach ($listRecord as $k => $record) {
                            $fish = $mFish->find($record['fish_id']);
                            $listRecord[$k]['fish'] = ($fish) ? $fish['name'] : 'Other families - Các loài khác';
                            $listRecord[$k]['captain'] = $mRecord->find($record['id'])->trips()->get()->first()->captains()->get()->first()->toArray()['fullname'];
                            $listRecord[$k]['vessel'] = $mRecord->find($record['id'])->trips()->get()->first()->captains()->get()->first()->toArray()['vessel'];

                            unset($listRecord[$k]['fish_id']);
                            unset($listRecord[$k]['created_at']);
                            unset($listRecord[$k]['updated_at']);

                            $arrRecord[$num] = [
                                'species' => $listRecord[$k]['fish'],
                                '#' => $num,
                                'captain' => urldecode($listRecord[$k]['captain']),
                                'vessel' => urldecode($listRecord[$k]['vessel']),
                                'lat' => $listRecord[$k]['lat'],
                                'lng' => $listRecord[$k]['lng'],
                                'data/time' => $listRecord[$k]['catched_at'],
                                'long' => $listRecord[$k]['long'],
                                'weight' => $listRecord[$k]['weight']
                            ];
                            $num++;
                        }
                    }
                }


                $sheet->fromArray($arrRecord);
            });
        })->download($ext);
    }

    /**
     * delete a captain
     *
     * @param [int] $id
     * @param Captain $mCaptain
     * @return void
     */
    public function getDelete($id, Captain $mCaptain)
    {
        // Del image
        // Del record
        // Del trip
        // Del captain
        $captain = $mCaptain->find($id);
        $listTrip = $captain->trips()->get();
        foreach ($listTrip as $trip) {
            $listRecord = $trip->records()->get();
            foreach ($listRecord as $record) {
                $listImg = json_decode($record['images']);
                foreach ($listImg as $img) {
                    if (File::exists(public_path() . '/data_sync/' . $img)) {
                        File::delete(public_path() . '/data_sync/' . $img);
                    }
                }
                $record->delete();
            }
            $trip->delete();
        }
        $captain->delete();
        return redirect()->route('list-captain')->with(['flashDataSuccess' => 'Delete successful!']);
    }
}