<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Record;
use App\Trip;
use App\Captain;
use App\Family;
use App\Fish;
use DB;

class HomeController extends Controller
{
    /**
     * redirect to link download app on CHPlay
     *
     * @return void
     */
    public function getApp()
    {
        return redirect()->to('https://play.google.com/store/apps/details?id=com.blogspot.tndev1403.Coppa');
    }

    /**
     * home dashboard
     *
     * @param Record $mRecord
     * @param Trip $mTrip
     * @param Captain $mCaptain
     * @param Fish $mFish
     * @param Family $mFamily
     * @return void
     */
    public function getIndex(Record $mRecord, Trip $mTrip, Captain $mCaptain, Fish $mFish, Family $mFamily)
    {
        // statistic_info
        $statistic_info['num_record'] = $mRecord->count();
        $statistic_info['num_trip'] = $mTrip->count();
        $statistic_info['num_captain'] = $mCaptain->count();
        $statistic_info['num_fish'] = $mFish->count();
        $statistic_info['num_family'] = $mFamily->count();

        // data for chart
        $data_chart = [];

        for ($i = 4; $i >= 0; $i--) {
            $tmpData = [];
            // get month
            $tmpData['y'] = date('Y-m', strtotime('-' . $i . ' months'));
            // captain
            $tmpData['captain'] = $mCaptain->where(DB::raw('MONTH(created_at)'), '=', date('n', strtotime('-' . $i . ' months')))->count();
            // trip
            $tmpData['trip'] = $mTrip->where(DB::raw('MONTH(created_at)'), '=', date('n', strtotime('-' . $i . ' months')))->count();
            // record
            $tmpData['record'] = $mRecord->where(DB::raw('MONTH(created_at)'), '=', date('n', strtotime('-' . $i . ' months')))->count();

            $data_chart[] = $tmpData;
        }

        // data for map
        $listRecord = $mRecord->where(DB::raw('MONTH(created_at)'), '=', date('n', time()))->get();
        $listMap = [];
        if (!empty($listRecord)) {
            foreach ($listRecord as $irecord) {
                $listMap[] = [
                    'latLng' => [floatval($irecord['lat']) - 0.2, floatval($irecord['lng']) + 95.8],
                    'name' => $irecord['id']
                ];
            }
        }


        // dd(json_encode($data_chart));
        $data['statistic_info'] = $statistic_info;
        $data['data_chart'] = $data_chart;
        $data['data_map'] = $listMap;
        return view('dashboard.home', $data);
    }
}