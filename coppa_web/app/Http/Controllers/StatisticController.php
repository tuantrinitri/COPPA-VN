<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Record;
use App\Fish;
use App\Captain;
use App\Trip;

use Excel, Auth;

use Illuminate\Support\Facades\Input;

class StatisticController extends Controller
{
    /**
     * view all statistic
     *
     * @param Record $mRecord
     * @param Fish $mFish
     * @param Captain $mCaptain
     * @param Trip $mTrip
     * @return void
     */
    public function getList(Record $mRecord, Fish $mFish, Captain $mCaptain, Trip $mTrip)
    {
        $search_form['captain_selected'] = Input::get('captain', 0);
        $search_form['fish_selected'] = Input::get('fish', 0);

        $listRecord = $mCaptain->orderBy('id', 'desc')->get()->toArray();
        foreach ($listRecord as $k => $captain) {
            $listRecord[$k]['trips'] = $mCaptain->where(['id' => $captain['id']])->get()->first()->trips()->get()->toArray();
            $tmpNumRec = 0;
            foreach ($listRecord[$k]['trips'] as $j => $trip) {
                $listRecord[$k]['trips'][$j]['records'] = $mTrip->where(['id' => $trip['id']])->get()->first()->records()->get()->toArray();
                foreach ($listRecord[$k]['trips'][$j]['records'] as $t => $record) {
                    $listRecord[$k]['trips'][$j]['records'][$t]['fish'] = $mFish->where(['id' => $record['fish_id']])->get()->first();

                    if (($listRecord[$k]['id'] != $search_form['captain_selected'] && $search_form['captain_selected'] > 0) || ($listRecord[$k]['trips'][$j]['records'][$t]['fish']['id'] != $search_form['fish_selected'] && $search_form['fish_selected'] > 0)) {
                        unset($listRecord[$k]['trips'][$j]['records'][$t]);
                    } else {
                        $tmpNumRec++;
                    }
                }
            }

            $listRecord[$k]['num_rows'] = $tmpNumRec;
        }

        $data['main_info'] = [
            'num_record' => $mRecord->count()
        ];

        // List captain and fish for search form
        $search_form['captain'] = $mCaptain->orderBy('id', 'desc')->get()->toArray();
        $search_form['fish'] = $mFish->orderBy('id', 'asc')->get()->toArray();
        $data['search_form'] = $search_form;

        $data['listRecord'] = $listRecord;
        return view('statistic.list', $data);
    }

    /**
     * download excel statistic
     *
     * @return void
     */
    public function downloadExcel()
    {
        if (Auth::user()->level != 1) return redirect()->route('home');

        // Preparing export excel
        $ext = 'xlsx';
        Excel::create('report_statistic_' . date('d.m.Y_H.i', time()), function ($excel) {
            $excel->sheet('Sheet 1', function ($sheet) {
                // Get list records
                $mRecord = new Record();
                $mFish = new Fish();
                $listRecord = $mRecord->orderBy('catched_at', 'asc')->get();
                $arrRecord = [];
                $num = 1;
                if ($listRecord) {
                    foreach ($listRecord as $k => $record) {
                        $fish = $mFish->find($record['fish_id']);
                        $listRecord[$k]['fish'] = ($fish) ? $fish['name'] : 'Other families - Các loài khác';
                        if ($mRecord->find($record['id'])->trips()->get()->first()) {
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
                        } else {
                            unset($listRecord[$k]);
                        }
                    }
                }

                $sheet->fromArray($arrRecord);
            });
        })->download($ext);
    }
}