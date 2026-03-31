<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\DesawarMarket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DesawarRecord;
use App\Services\DesawarRecordChartService;
use Illuminate\Support\Facades\DB;

class DesawarMarketController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('searchValue')) {
            $searchValue = $request->searchValue;
            $desawarMarkets = DesawarMarket::where('name', 'LIKE', '%' . $searchValue . '%')
                ->latest()->paginate(250);
            return view("dashboard.desawar-markets.index", compact('desawarMarkets', 'searchValue'));
        }
        $desawarMarkets = DesawarMarket::latest()->paginate(25);
        return view("dashboard.desawar-markets.index", compact('desawarMarkets'));
    }
    public function create()
    {
        return view('dashboard.desawar-markets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'api_key_name' => 'required|max:255',
            'disable_game' => 'required|boolean',
            'previous_day_check' => 'required|boolean',
            'open_time' => 'required',
            'close_time' => 'required',
            'result_time' => 'required',

            //criteria 1 (their timings & max bet amount)
            'c_time_start' => 'required',
            'c_time_end' => 'required|after:c_time_start',
            'c_max_bet_amount' => 'required|numeric',

            //criteria 2 (their timings & max bet amount)
            'c2_time_start' => 'required',
            'c2_time_end' => 'required|after:c2_time_start',
            'c2_max_bet_amount' => 'required|numeric',

            //criteria 3 (their timings & max bet amount)
            'c3_time_start' => 'required',
            'c3_time_end' => 'required|after:c3_time_start',
            'c3_max_bet_amount' => 'required|numeric',
        ]);
        DesawarMarket::create($request->all());
        return redirect()->route('desawar-markets.index')->with('success', 'Market Created successfully');
    }

    public function edit($id)
    {
        $market = DesawarMarket::findOrFail($id);
        return view('dashboard.desawar-markets.create', compact('market'));
    }

    public function chart()
    {
        $chartData = DesawarRecordChartService::getChartData();
        $desawarMarketLimit = \App\Models\DesawarMarketLimit::find(1);

        return view('dashboard.desawar-markets.chart', [...$chartData, 'desawarMarketLimit' => $desawarMarketLimit]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'api_key_name' => 'required|max:255',
            'previous_day_check' => 'required|boolean',
            'open_time' => 'required',
            'close_time' => 'required',
            'result_time' => 'required',

            //criteria 1 (their timings & max bet amount)
            'c_time_start' => 'required',
            'c_time_end' => 'required',
            'c_max_bet_amount' => 'required|numeric',

            //criteria 2 (their timings & max bet amount)
            'c2_time_start' => 'required',
            'c2_time_end' => 'required',
            'c2_max_bet_amount' => 'required|numeric',

            //criteria 3 (their timings & max bet amount)
            'c3_time_start' => 'required',
            'c3_time_end' => 'required',
            'c3_max_bet_amount' => 'required|numeric',

        ]);
        $market = DesawarMarket::findOrFail($id);
        $market->name = $request->name;
        $market->disable_game = $request->disable_game;
        $market->api_key_name = $request->api_key_name;
        $market->previous_day_check = $request->previous_day_check;
        $market->open_time = $request->open_time;
        $market->close_time = $request->close_time;
        $market->result_time = $request->result_time;
        $market->auto_result = $request->auto_result;

        //criteria 1 (their timings & max bet amount)
        $market->c_time_start = $request->c_time_start;
        $market->c_time_end = $request->c_time_end;
        $market->c_max_bet_amount = $request->c_max_bet_amount;

        //criteria 2 (their timings & max bet amount)
        $market->c2_time_start = $request->c2_time_start;
        $market->c2_time_end = $request->c2_time_end;
        $market->c2_max_bet_amount = $request->c2_max_bet_amount;

        //criteria 3 (their timings & max bet amount)
        $market->c3_time_start = $request->c3_time_start;
        $market->c3_time_end = $request->c3_time_end;
        $market->c3_max_bet_amount = $request->c3_max_bet_amount;


        $market->update();
        return redirect()->route('desawar-markets.index')->with('success', 'Market Update successfully');
    }

    public function destroy($id)
    {
        $market = DesawarMarket::findOrFail($id);
        foreach ($market->records as $record) {
            $record->delete();
        }
        foreach ($market->results as $result) {
            $result->delete();
        }
        $market->delete();
        return redirect()->route('desawar-markets.index')->with('success', 'Market Deleted successfully');
    }
}
