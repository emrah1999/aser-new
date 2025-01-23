<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class PartnerCalculator
{
    private $location;
    private $is_pick_up;
    private $weight;

    public function __construct($location, $is_pick_up, $weight)
    {
        $this->location = $location;
        $this->is_pick_up = $is_pick_up;
        $this->weight = $weight;
    }

    public function calculateAmount()
    {
        $city = mb_strtoupper($this->location->city, 'UTF-8') !== mb_strtoupper('Baku', 'UTF-8') && mb_strtoupper($this->location->city, 'UTF-8') !== mb_strtoupper('Baki', 'UTF-8');

        $filteredContracts = $this->filterContracts($this->weight);

        if ($this->is_pick_up == 'from_office') {
            return $this->calculateAmountForContractType($filteredContracts, 2);
        }

        if ($city) {
            return $this->calculateAmountForContractType($filteredContracts, 3);
        }

        if (!$city) {
            return $this->checkCourierType($filteredContracts, $this->location->region);
        }

        return null;
    }

    private function filterContracts($weight)
    {
        $platformContract = DB::table('platform_contract_details')->get();

        $filteredContracts = $platformContract->filter(function ($contract) use ($weight) {
            return $weight >= $contract->from_weight && $weight <= $contract->to_weight;
        });

        return $filteredContracts;
    }


    private function calculateAmountForContractType($filteredContracts, $contractType)
    {
        $officeAmount = $filteredContracts->firstWhere('contract_id', $contractType);

        if ($officeAmount) {
            return ($officeAmount->rate * $this->weight) + $officeAmount->charge;
        }

        return null;
    }


    private function checkCourierType($filteredContracts, $clientRegion)
    {

        $azerpost_region = DB::table('azerpost_region')
            ->select('area_id', 'region_id')
            ->whereRaw('UPPER(SUBSTRING_INDEX(name, " ", 1)) = UPPER(SUBSTRING_INDEX(?, " ", 1))', [$clientRegion])
            ->where(function ($query) {
                $query->whereNotNull('area_id')
                    ->orWhereNotNull('region_id');
            })
            ->first();

        if (!$azerpost_region) {
            return $this->calculateAmountForContractType($filteredContracts, 3);
        }

        $areaId = $azerpost_region->area_id;
        //$regionId = $azerpost_region->region_id;

        $contractType = $areaId ? 1 : 3;


        return $this->calculateAmountForContractType($filteredContracts, $contractType);
    }

}