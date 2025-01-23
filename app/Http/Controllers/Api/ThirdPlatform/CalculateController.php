<?php

namespace App\Http\Controllers\Api\ThirdPlatform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\ChangeAccountLog;
use App\Container;
use App\Contract;
use App\ContractDetail;
use App\User;
use App\Item;
use App\Currency;
use Carbon\Carbon;

class CalculateController extends Controller
{
    public function calculate_amount($client_id, $departure, $destination, $category_id, $seller_id, $gross_weight, $volume_weight, $length, $width, $height, $tariff_type_id, $has_chargeable = 1)
	{
		try {
			$current_date = Carbon::today();
			$def = false;
			$contract_id = 0;
			$chargeable_weight = 0;
			$amount = 0;
			$currency_name = '';
			$currency_id = 0;
			$used_detail_id = 0;
			$chargeable_weight_type = 1; // 1 - gross; 2 - volume

			$client_contract = User::where('id', $client_id)->whereNull('deleted_by')->select('contract_id')->first();
			if ($client_contract) {
				if ($client_contract->contract_id != null) {
					$contract_id = $client_contract->contract_id;
					if (Contract::where('id', $contract_id)->where('start_date', '<=', $current_date)->where('end_date', '>=', $current_date)->where('is_active', 1)->whereNull('deleted_by')->count() == 0) {
						//default contract
						$def = true;
					}
					
				} else {
					//default contract
					$def = true;
				}
			
			} else {
				//default contract
				$def = true;
			}
			
			//get default contract
			if ($def) {
				$default_contract = Contract::where('default_option', 1)->where('is_active', 1)->where('start_date', '<=', $current_date)->where('end_date', '>=', $current_date)->whereNull('deleted_by')->orderBy('id', 'desc')->select('id')->first();
				if ($default_contract) {
					$contract_id = $default_contract->id;
				} else {
					$contract_id = 0;
				}
			}
			
			//contract exists control
			if ($contract_id == 0) {
				return ['type' => false, 'response' => 'No valid contract found 0!'];
			}

			//get contract details
			$details = ContractDetail::where(['contract_id' => $contract_id, 'type_id' => $tariff_type_id])->whereNull('deleted_by')
					->where('start_date', '<=', $current_date)
					->where('end_date', '>=', $current_date)
                    ->where(function ($query) use ($seller_id) {
                        $query->where('seller_id', null);
                        $query->orWhere('seller_id', $seller_id);
                    })
                    ->where(function ($query) use ($category_id) {
                        $query->where('category_id', null);
                        $query->orWhere('category_id', $category_id);
                    })
					->where(['departure_id' => $departure, 'destination_id' => $destination])
					->select('id', 'seller_id', 'category_id', 'weight_control', 'from_weight', 'to_weight', 'rate', 'charge', 'currency_id')
					->get();
					// dd($details);
			if (count($details) == 0) {
				// dd($details);
				if ($def) {
					// dd($def);
					return ['type' => false, 'response' => 'No valid rate found 0!'];
				} else {
					//get default contract
					$default_contract = Contract::where('default_option', 1)->where('is_active', 1)->where('start_date', '<=', $current_date)->where('end_date', '>=', $current_date)->whereNull('deleted_by')->orderBy('id', 'desc')->select('id')->first();
					if ($default_contract) {
						$contract_id = $default_contract->id;
						
						$details = ContractDetail::where(['contract_id' => $contract_id, 'type_id' => $tariff_type_id])->whereNull('deleted_by')
								->where('start_date', '<=', $current_date)
								->where('end_date', '>=', $current_date)
								->where(['departure_id' => $departure, 'destination_id' => $destination])
                                ->where(function ($query) use ($seller_id) {
                                    $query->where('seller_id', null);
                                    $query->orWhere('seller_id', $seller_id);
                                })
                                ->where(function ($query) use ($category_id) {
                                    $query->where('category_id', null);
                                    $query->orWhere('category_id', $category_id);
                                })
								->select('id', 'seller_id', 'category_id', 'weight_control', 'from_weight', 'to_weight', 'rate', 'charge', 'currency_id')
								->get();
								// dd($details);
						if (count($details) == 0) {
							return ['type' => false, 'response' => 'No valid rate found 1!'];
						}
					} else {
						return ['type' => false, 'response' => 'No valid contract found 1!'];
					}
				}
			}

			$rates = array();
			$rate_count = 0;
			$choose_details = $this->choose_details($details, $volume_weight, $length, $width, $height, $gross_weight, $category_id, $seller_id, $has_chargeable);
			$rates = $choose_details['rates'];
			$rate_count = $choose_details['rate_count'];
			$chargeable_weight_type = $choose_details['chargeable_weight_type'];
			$chargeable_weight = $choose_details['chargeable_weight'];
            
			if ($rate_count == 0) {
				if ($def) {
					return ['type' => false, 'response' => 'No valid rate found!'];
				} else {
					//get default contract
					$default_contract = Contract::where('default_option', 1)->where('is_active', 1)->where('start_date', '<=', $current_date)->where('end_date', '>=', $current_date)->whereNull('deleted_by')->orderBy('id', 'desc')->select('id')->first();
					if ($default_contract) {
						$contract_id = $default_contract->id;
						$details = ContractDetail::where(['contract_id' => $contract_id, 'type_id' => $tariff_type_id])->whereNull('deleted_by')
								->where('start_date', '<=', $current_date)
								->where('end_date', '>=', $current_date)
								->where(['departure_id' => $departure, 'destination_id' => $destination])
                                ->where(function ($query) use ($seller_id) {
                                    $query->where('seller_id', null);
                                    $query->orWhere('seller_id', $seller_id);
                                })
                                ->where(function ($query) use ($category_id) {
                                    $query->where('category_id', null);
                                    $query->orWhere('category_id', $category_id);
                                })
								->select('id', 'seller_id', 'category_id', 'weight_control', 'from_weight', 'to_weight', 'rate', 'charge', 'currency_id')
								->get();

						if (count($details) == 0) {
							return ['type' => false, 'response' => 'No valid rate found 2!'];
						}

						$rates = array();
						$rate_count = 0;
						$choose_details = $this->choose_details($details, $volume_weight, $length, $width, $height, $gross_weight, $category_id, $seller_id, $has_chargeable);
						$rates = $choose_details['rates'];
						$rate_count = $choose_details['rate_count'];
						$chargeable_weight_type = $choose_details['chargeable_weight_type'];
						$chargeable_weight = $choose_details['chargeable_weight'];

						if ($rate_count == 0) {
							return ['type' => false, 'response' => 'No valid rate found 3! '];
						}
					} else {
						return ['type' => false, 'response' => 'No valid contract found 2!'];
					}
				}
			}

			//sort rates
			$rates = collect($rates)->sortBy('id')->reverse()->toArray();
			$rates = collect($rates)->sortBy('priority')->reverse()->toArray();

			$selected_rate = false;
			$rate_first = false;
			foreach ($rates as $rate) {
				if ($rate_first == false) {
					$selected_rate = $rate;
					$rate_first = true;
				} else {
					break;
				}
			}

			if ($selected_rate == false) {
				return ['type' => false, 'response' => 'No valid rate found 4!'];
			} else {
				$selected_rate_id = $selected_rate['id'];
			}

			foreach ($details as $detail) {
				if ($detail->id == $selected_rate_id) {
					$used_detail_id = $detail->id;
					$rate_value = $detail->rate;
					$charge = $detail->charge;
					$currency_id = $detail->currency_id;
					$currency = Currency::where('id', $currency_id)->select('name')->first();
					if ($currency) {
						$currency_name = $currency->name;
					}

					$amount = ($chargeable_weight * $rate_value) + $charge;
					break;
				}
			}

			$amount = number_format((float)$amount, 2, '.', '');

			return ['type' => true, 'amount' => $amount, 'currency' => $currency_name, 'currency_id' => $currency_id, 'chargeable_weight_type' => $chargeable_weight_type, 'used_contract_detail_id' => $used_detail_id];
		} catch (\Exception $exception) {
			return ['type' => false, 'response' => 'Something went wrong when contract selected!'];
		}
	}

	private function choose_details($details, $volume_weight, $length, $width, $height, $gross_weight, $category_id, $seller_id, $has_chargeable = 1)
	{
		$rates = array();
		$rate_count = 0;
		$chargeable_weight = 0;
		$chargeable_weight_type = 1; // 1 - gross; 2 - volume
		$i = 0;

		foreach ($details as $detail) {
			if ($has_chargeable === 2) {
				//gross weight
				$chargeable_weight = $gross_weight;
				$chargeable_weight_type = 1;
			} else if ($has_chargeable === 3) {
				//volume weight
				$chargeable_weight = $volume_weight;
				$chargeable_weight_type = 2;
			} else {
				//default
				if ($detail->weight_control === 1) {
					if ($length > 0 && $width > 0 && $height > 0) {
						if ($volume_weight > $gross_weight) {
							$chargeable_weight = $volume_weight;
							$chargeable_weight_type = 2;
						} else {
							$chargeable_weight = $gross_weight;
							$chargeable_weight_type = 1;
						}
					} else {
						$chargeable_weight = $gross_weight;
						$chargeable_weight_type = 1;
					}
				} else {
					$chargeable_weight = $gross_weight;
					$chargeable_weight_type = 1;
				}
			}


			if (($chargeable_weight >= $detail->from_weight) && ($chargeable_weight <= $detail->to_weight)) {
				//ok
				if ($detail->seller_id == null && $detail->category_id == null) {
					//no seller and no category
					//priority = 0
					$rate_count++;
					$rates[$rate_count]['id'] = $detail->id;
					$rates[$rate_count]['priority'] = 0;
				}
				if ($detail->seller_id == null && $detail->category_id != null) {
					//only category
					//priority = 1
					if ($detail->category_id == $category_id) {
						$rate_count++;
						$rates[$rate_count]['id'] = $detail->id;
						$rates[$rate_count]['priority'] = 1;
					}
				}
				if ($detail->category_id == null && $detail->seller_id != null) {
					//only seller
					//priority = 2
					if ($detail->seller_id == $seller_id) {
						$rate_count++;
						$rates[$rate_count]['id'] = $detail->id;
						$rates[$rate_count]['priority'] = 2;
					}
				}
				if ($detail->seller_id != null && $detail->category_id != null) {
					//seller and category
					//priority = 3
					if ($detail->seller_id == $seller_id && $detail->category_id == $category_id) {
						$rate_count++;
						$rates[$rate_count]['id'] = $detail->id;
						$rates[$rate_count]['priority'] = 3;
					}
				}
			} else {
				continue;
			}
		}

		return ['rates' => $rates, 'rate_count' => $rate_count, 'chargeable_weight_type' => $chargeable_weight_type, 'chargeable_weight' => $chargeable_weight];
	}
}
