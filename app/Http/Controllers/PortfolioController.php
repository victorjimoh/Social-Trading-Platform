<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\FinanceAPI;
use App\UserUtility;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    public function getBalance($json)
    {
        return $json->portfolios->cash_owned;
    }
    public function getPortfolioValue($data, $tickers)
    {
        // Gets all user's current total price for each company
        $prices = $this->getAllPrices($data, $tickers);

        // Returns sum of all prices
        return $this->sumAll($prices);
    }
    public function getPortfolioLastCloseValue($data, $tickers)
    {
        // Gets all user's last daily close price for each company
        $prices = $this->getAllLastClosePrices($data, $tickers);

        // Returns sum of all prices
        return $this->sumAll($prices);
    }
    private function loadMetadata($user)
    {
        // Gets authenticated user's metadatas
        $user->portfolios->portfolio_stocks;

        // Loads all metadata
        $stocksData = $user->portfolios->portfolio_stocks;

        // Gets all user's share counts
        $tickers = $this->getShareCount($stocksData);

        // Returns stock information through API request and tickers
        return array(
            'info' => FinanceAPI::getAllStockInfo(array_keys($tickers)),
            'tickers' => $tickers
        );
    }
    private function getShareCount($metadata)
    {
        $shareCount = array();
        foreach ($metadata as $value) {
            $shareCount[$value->ticker_symbol] = $value->share_count;
        }

        return $shareCount;
    }
    private function getAllPrices($data, array $tickers)
    {
        $currentPrices = array();
        foreach ($data as $value) { // Loop through array 
            foreach ($tickers as $key => $share) { // Loop through all user's share count
                if ($value['symbol'] === $key) { // Check if symbols are matching
                    array_push($currentPrices, $value['price'] * $share);
                }
            }
        }

        return $currentPrices;
    }
    private function getAllLastClosePrices($data, array $tickers)
    {
        $lastClosePrice = array();
        foreach ($data as $value) { // Loop through array 
            foreach ($tickers as $key => $share) { // Loop through all user's share count
                if ($value['symbol'] === $key) { // Check if symbols are matching
                    array_push($lastClosePrice, $value['close_yesterday'] * $share);
                }
            }
        }

        return $lastClosePrice;
    }
    private function sumAll(array $prices)
    {
        $sum = 0;
        foreach ($prices as $value) {
            $sum += $value;
        }

        return $sum;
    }


}


