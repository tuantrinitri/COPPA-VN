<?php

namespace App\Http\Controllers;

use App\Family;

class FamilyController extends Controller
{
    /**
     * view list family
     *
     * @param Family $mFamily
     * @return void
     */
    public function getList(Family $mFamily)
    {
        $listFamily = $mFamily->all()->toArray();
        $data['listFamily'] = $listFamily;
        return view('family.list', $data);
    }

    /**
     * view detail family
     *
     * @param [int] $id
     * @param Family $mFamily
     * @return void
     */
    public function getDetail($id, Family $mFamily)
    {
        $family = $mFamily->find($id);
        $listFish = $family->fishes()->get()->toArray();
        $data['family'] = $family->toArray();
        $data['listFish'] = $listFish;
        return view('family.detail', $data);
    }
}