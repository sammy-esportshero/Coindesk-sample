<?php
/**
 * Created by PhpStorm.
 * User: Sammy
 * Date: 8/3/2017
 * Time: 1:39 PM
 */

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Input;

class CoinCapController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new GuzzleHttp\Client();
    }

    public function getCurrentPortfolioValue($portfolio)
    {
        //Hit CoinCap /front w/ Guzzle
        $result = $this->client->get(
            'http://www.coincap.io/front'
        );
        $data = $result->getBody()->getContents();
        $values = json_decode($data);

        //Compute portfolio total value
        $portfolio_value = 0;
        foreach($values as $value) {
            if(array_key_exists($value->short,$portfolio)) {
                $portfolio_value += $portfolio[$value->short] * $value->price;
            }
        }

        return $portfolio_value;
    }

    public function getHistoricalPortfolioValue($portfolio)
    {
        $portfolio_value = 0;
        foreach($portfolio as $fund => $amount) {
            if(empty($amount)) continue;

            //Hit CoinCap /historical w/ Guzzle
            $result = $this->client->get(
                "http://www.coincap.io/history/1day/{$fund}"
            );
            $data = $result->getBody()->getContents();
            $values = json_decode($data);
            $prices = $values->price;

            //Looks like the prices have a ton of data samples over the last 24 hours
            //What I'll do is find the price at the time closest to 24 hours before now
            $currTime = time();
            $oneDayAgo = $currTime - (24 * 60 * 60);

            $shortestDistance = PHP_INT_MAX;
            $shortestDistancePrice = -1;
            foreach ($prices as $price) {
                //For some reason the +000 is concatenated at the end of the time
                //I divide by 1000 to get rid of that
                $distance = abs($oneDayAgo - $price[0]/1000);
                if ($distance < $shortestDistance) {
                    $shortestDistance = $distance;
                    $shortestDistancePrice = $price[1];
                }
            }

            $portfolio_value += $amount * $shortestDistancePrice;
        }

        return $portfolio_value;
    }

    public function getPortfolioROI(Request $request)
    {
        //Get Portfolio's Current Value and 1 day old value
        //TODO: Ideally the '1 day' would not be hardcoded
        $portfolio = array_change_key_case($request->all(), CASE_UPPER);

        //Don't process portfolio if empty
        //Uglier than an array filter, but faster
        $valid = false;
        foreach($portfolio as $key => $value) {
            if(!empty($value)) {
                $valid = true;
                break;
            }
        }
        if(!$valid) return 0;

        $currentValue = $this->getCurrentPortfolioValue($portfolio);
        $historicalValue = $this->getHistoricalPortfolioValue($portfolio);

        //return % diff
        return (1 - ($currentValue/$historicalValue))*100;
    }
}