<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Portfolio_Stock;
use App\UserUtility;
use App\FinanceAPI;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\CurrencyConverter;

class MarketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Performs quoting on inputted strings. Calls API to get
     * information about each symbol. Symbols can be delimited by the
     * following characters: {",", " ", "-", ";", ":"}. Spaces are
     * are omitted.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function quotes(Request $request)
    {
        $symbol = trim($this->sanitize($request->input("ticker_symbol")));
        if (is_string($symbol) && strlen($symbol) > 0) {
            $symbols = preg_split("/(,| |-|;|:)/", $symbol, -1, PREG_SPLIT_NO_EMPTY);
            if (count($symbols) > 0) {
                $allQuotes = FinanceAPI::getAllStockInfo($symbols);
                if (!$this->isValidApi($allQuotes)) {
                    return $this->viewHome(
                        "No information shown due to maximum (250) reach of daily API requests. 
                        Resets at 12PM (UTC).
                        We apologize for the inconvenience this has caused.",
                        'danger'
                    );
                }
                
                $data = $this->getDataForView();
                $data["quotes"] = $allQuotes;

                return view("market", $data);
            }
        }
        return $this->redirectHome('Inputted symbol(s) is invalid!', 'danger');
    }

    /**
     * Endpoint function for a transaction. Determine whether it is
     * for buying or for selling by using Request object.
     *
     * @param Request $request
     * @param string $symbol ticker symbol
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function transaction(Request $request, $symbol)
    {
        $data = array();
        // Type of the request (buy or sell)
        $type = $this->sanitize($request->input('type'));
        if (isset($type) && is_string($type)) {
            if (strtolower($type) == 'sell') {
                $data['action'] = 'sell';
            } else if (strtolower($type) == 'buy') {
                $data['action'] = 'buy';
            } else {
                return $this->redirectHome('Invalid request', 'danger');
            }
            // Add basic user stocks data to array
            $data = array_merge($data, $this->getDataForView());
            $data['stockPerform'] = $this->getStockFromStocks($symbol, $data['stocks']);
        } else {
            $data = [
                'message' => 'Invalid request!',
                'messageType' => 'danger',
            ];
        }
        return view('market', $data);
    }

    /**
     * Find a stock out of many stocks
     *
     * @param $symbol
     * @param $stocks array haystack
     * @return mixed Stock formatted as the api response
     */
    private function getStockFromStocks($symbol, $stocks)
    {
        foreach ($stocks as $stock) {
            if ($stock['symbol'] === $symbol) {
                return $stock;
            }
        }
    }

    /**
     * Sells the user's given stock if permitted.
     *
     * @param Request $request
     * @param $symbol
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sell(Request $request, $symbol)
    {
        $user = Auth::user();

        // Access the share count from the form
        $shareCount = $this->sanitize($request->input('share_count'));

        $data = array();
        if (is_numeric($shareCount) && $shareCount > 0) {
            $shareCount = floor($shareCount);
            // Execute the sale, validation is done within this function
            $response = UserUtility::sellShares($user, $symbol, $shareCount);
            if ($response !== true) {
                // String returned from sellShares is an error message
                return $this->redirectHome($response, 'danger');
            } else if($response === true) {
                return $this->redirectHome('Successfully sold '.$shareCount.' stock(s) of '.$symbol.' from your portfolio.', 'success');
            }
        }
        return $this->redirectHome('Invalid number of stocks entered', 'danger');
    }

    /**
     * Adds entry to Portfolio_Stock table
     *
     * @param Request $request
     * @param $symbol Ticker of company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function purchaseStock(Request $request, $symbol)
    {
        $user = Auth::user();
        $quote = FinanceAPI::getAllStockInfo(explode(",", $symbol));
        if (!$this->isValidApi($quote)) {
            return $this->viewHome(
                "No information shown due to maximum (250) reach of daily API requests. 
                Resets at 12PM (UTC).
                We apologize for the inconvenience this has caused.",
                'danger'
            );
        }
        $shares = $this->sanitize($request->input("share_count"));

        if (is_numeric($shares) && $shares > 0) {
            //dd($quote['data'][0]["close"]);
            $cost = CurrencyConverter::convertToUSD("NGN", $quote["data"][0]["close"]) * $shares;
            if (!UserUtility::hasEnoughCash($user, $cost)) {
                return $this->redirectHome('You didn\'t have enough cash to complete the last purchase', 'danger');
            }

            if (UserUtility::hasMaxAndCantUpdate($user, $quote)) {
                return $this->redirectHome('You already have shares with 5 different companies', 'danger');
            }

            $shares = floor($shares);
            UserUtility::storeStock($user, $quote, $shares);

            return $this->redirectHome('Successfully purchased '.$shares.' stock(s) of '.$symbol.'.', 'success');
        }
        return $this->redirectHome('Invalid number of stocks entered', 'danger');    
    }

    /**
     * Show the application dashboard. Uses flashed data stored during
     * actions to display messages to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieves all tickers from database associated with authenticated user
        $user = Auth::user();

        // User has stocks to show
        if(!$this->hasNoPortfolio($user)) {
            $portfolioStocksInfo = $user->portfolios->portfolio_stocks;
            $allTickers = $this->getTickers($portfolioStocksInfo);
            // Pings API to check if daily API requests are available
            $stocksData = FinanceAPI::getAllStockInfo($allTickers);
            if (!$this->isValidApi($stocksData)) {
                return $this->viewHome(
                    "No information shown due to maximum (250) reach of daily API requests. 
                    Resets at 12PM (UTC).
                    We apologize for the inconvenience this has caused.",
                    'danger'
                );
            }
        }
        
        $data = $this->getDataForView();
        $message = session()->get('message');
        $messageType = session()->get('messageType');
        if(isset($message) && isset($messageType)) {
            $data['message'] = $message;
            $data['messageType'] = $messageType;
        }
        return view('market', $data);    
    }

    /**
     * Get all the info that is needed for the the homepage information.
     * @return array with array containing the data to be displayed on home page.
     */
    private function getDataForView()
    {
        $user = Auth::user();
        $data = array();
        if($this->hasNoPortfolio($user))
        {
            $data = $this->showNoData($user);
            $data['portfolio'] = $this->getPortfolioData($user);
        } else {
            $data = $this->showData($user);
        }
        return $data;
    }

    /**
     * Checks the user's information in the database to see if they 
     * have any stocks in their portfolio. The function returns 
     * true if the user exists and has no portfolio created or 
     * has no stocks to show.
     * 
     * @param User $user Trying to sign in
     * @return True if user has nothing to show, false otherwise
     */
    private function hasNoPortfolio($user) 
    {
        return !isset($user->portfolios) || count($user->portfolios->portfolio_stocks) == 0;
    }

    /**
     * Set up of the data needed for the homepage if the user has no data yet.
     *
     * @param $user User that is currently authenticated
     * @return array with error details
     */
    private function showNoData($user)
    {
        // Create portfolio for the new user and give default balance
        if (!isset($user->portfolios)) {
            $this->createPortfolio($user);
        }
        return [
            'error' => 'true',
            'errorMsg' => 'No stocks to show!',
        ];
    }

    /**
     * Creates a new portfolio for the given user.
     * Assigns it the default balance value coming from the
     * config\constants.php file.
     *
     * @param $user User
     */
    private function createPortfolio($user)
    {
        $portfolio = new Portfolio();
        $portfolio->user_id = $user->id;
        $portfolio->cash_owned = Config::get('constants.options.DEFAULT_BALANCE');

        $user->portfolios = $portfolio;
        $user->portfolios->save();
    }

    /**
     * Performs all necessary actions related to getting the data associated
     * with the authenticated user. Actions include fetching the user's owned
     * stocks and their portfolio details.
     *
     * @param $user User that is currently authenticated
     * @return array containing all data necessary for the homepage.
     */
    private function showData($user)
    {
        $portfolio = $user->portfolios;

        // Array of stocks (comes from database)
        $dbStocks = $portfolio->portfolio_stocks;

        // Array of ticker symbols
        $tickers = $this->getTickers($dbStocks);

        $stocks = array();
        $shareCounts = array();
        // Get data associated with each stock
        if (count($tickers) > 0) {
            // Array of stock data (comes from API call)
            $stocksInfo = FinanceAPI::getAllStockInfo($tickers);
            if (!$this->isValidApi($stocksInfo)) {
                return $this->viewHome(
                    "No information shown due to maximum (250) reach of daily API requests. 
                    Resets at 12PM (UTC).
                    We apologize for the inconvenience this has caused.",
                    'danger'
                );
            }
            // Returns a single array containing all the necessary information
            // for stocks with pricing in USD.
            $stocks = $this->getStocksInfo($dbStocks, $stocksInfo['data']);
            // Share count for each stock
            $shareCounts = $this->getShareCounts($stocks);
            
        }
        // More details on the portfolio includes: cash_owned, value, last close value
        $portfolioDetails = $this->getPortfolioData($user, $stocks, $shareCounts);

        return [
            'user' => $user,
            'portfolio' => $portfolioDetails,
            'stocks' => $stocks,
        ];
    }

    /**
     * Checks if the API is valid by retrieve the message attribute.
     * If it exists, that means an error has occurred. If it does not
     * it is valid.
     * 
     * @param $data Stock information
     * @return bool True if valid else false
     */
    private function isValidApi($data)
    {
        if (isset($data['message'])) {
            if ($data['message'] === "You have reached your request limit for the day. Upgrade to get more daily requests.") {
                return false;
            }
            if ($data['message'] === "Error! The requested stock(s) could not be found.") {
                return false;
            }
        }
        return true;
    }

    /**
     * Perform a series of operations on the stocks.
     * 1) Keep the data that is relevant for the homepage.
     * 2) Convert pricing to USD (some fields remain with the
     * original pricing and currency in case it is needed).
     *
     * @param $dbStocks array of stocks coming from the database
     * @param $stocksData array of stocks data coming from API
     * @return array Contains the combined data from the stocks
     * provided from the database and those coming from the API.
     */
    private function getStocksInfo($dbStocks, $stocksData)
    {
        $stocks = array();
        foreach ($dbStocks as $dbStock) {
            foreach ($stocksData as $data) {
                // Matching data from API and from database
                if ($dbStock->ticker_symbol === $data['symbol']) {
                    // Updated stock object with all the data needed
                    $stock = $this->keepNecessaryInfo($dbStock, $data);
                    // Convert all the pricing to USD
                    $this->convertPricesToUSD($stock);
                    // Add the individual stock data to the array
                    array_push($stocks, $stock);
                }
            }
        }
        return $stocks;
    }

    /**
     * Get an array of ticker symbols from an array of stocks.
     *
     * @param $stocks array of stocks
     * @return array of tickers
     */
    private function getTickers($stocks)
    {
        $tickers = array();
        foreach ($stocks as $stock) {
            array_push($tickers, $stock->ticker_symbol);
        }
        return $tickers;
    }

    /**
     * Gets the share count for each stock.
     * The returned associative array has key as symbol and value as
     * share count.
     *
     * @param $stocks array associative containing stock data
     * @return array associative containing symbols => count
     */
    private function getShareCounts($stocks)
    {
        $shareCounts = array();
        foreach ($stocks as $stock) {
            $shareCounts[$stock['symbol']] = $stock['count'];
        }
        return $shareCounts;
    }

    /**
     * This function only keeps the necessary info for the app. If
     * the view needs more info, add here.
     *
     * @param $stock Portfolio_Stock model object
     * @param $data JSON object containing extra data on this stock
     * @return array contains info about the stock
     */
    private function keepNecessaryInfo($stock, $data)
    {
        return [
            'id' => $stock->id,
            'count' => $stock->share_count,
            'symbol' => $data['symbol'],
            'company' => $data['symbol'],
            'currency' => "NGN",
            'price' => $data['close'],
            'close_yesterday' => $data['close'],
            'change' => $data['close'],
        ];
    }

    /**
     * Retrieves more information of the user's portfolio according
     * to their stocks.
     *
     * @param $user User contains stored information from database
     * @param $stocks array of JSON stock objects
     * @param $shareCounts array associative . Key is the ticker symbol,
     * value is the share count for the corresponding symbol.
     * @return array containing portfolio details
     */
    private function getPortfolioData($user, $stocks = array(), $shareCounts = array())
    {
        $portfolioController = new PortfolioController();

        $value = 0;
        $closeValue = 0;
        $portfolioChange = 0;
        if (count($stocks) > 0 && count($shareCounts) > 0) {
            $value = $portfolioController->getPortfolioValue($stocks, $shareCounts);
            $closeValue = $portfolioController->getPortfolioLastCloseValue($stocks, $shareCounts);
            $portfolioChange = UserUtility::getPercentageChange($value, $closeValue);
        }

        return [
            'cash' => $user->portfolios->cash_owned,
            'since' => self::getDateFromTimestamp($user->created_at),
            'value' => $value,
            'closeValue' => $closeValue,
            'portfolioChange' => $portfolioChange,
        ];
    }

    /**
     * Convert the currency of all the prices if it is not in USD. Param
     * is passed by reference -> no need to reassign any values.
     *
     * @param $data JSON object containing the data from the API response.
     */

    private function convertPricesToUSD(&$data)
    {
        $currency = "NGN";
        if ($currency != "USD") {
            $data['orig_currency'] = $currency;
           // $data['orig_price'] = $data['close'];
           /// $data['orig_close_yesterday'] = $data['close'];

           // $price = CurrencyConverter::convertToUSD($currency, $data['close']);
           // $lastClose = CurrencyConverter::convertToUSD($currency, $data['close']);

            // Reset the $data contents
           // $data['price'] = $price;
           // $data['close_yesterday'] = $lastClose;
           // $data['currency'] = "USD";
        }
    }

    /**
     * Extracts the date from a timestamp.
     * @param $tm string timestamp to extract from
     * @return string date
     */
    public static function getDateFromTimestamp($tm)
    {
        $pos = strpos($tm, ' ');
        return substr($tm, 0, $pos);
    }

    /**
     * Strips any html tags and returns the string.
     *
     * @param string $str string to validate
     * @return string after sanitation
     */
    private function sanitize($str)
    {
        $str = strip_tags($str);
        $str = htmlentities($str);
        return $str;
    }

    /**
     * Redirects the user back to the home page route and provides details
     * on the action's result using flashed data.
     * 
     * @param string $message Message to be displayed to the user.
     * @param string $messageType Type of the message. Possible values for
     * message type are as follows: {'success', 'danger'}
     * @return redirect to the home page with flashed data
     */
    private function redirectHome(string $message, string $messageType) 
    {
        return redirect()->route('market')->with([
            'message' => $message,
            'messageType' => $messageType,
        ]);
    }

    /**
     * Returns the user back to the home page and provides details
     * on the action's result.
     * 
     * @param string $message Message to be displayed to the user.
     * @param string $messageType Type of the message. Possible values for
     * message type are as follows: {'success', 'danger'}
     * @return Illuminate\View\View Home page view
     */
    private function viewHome(string $message, string $messageType) 
    {
        return view('market', [
            'message' => $message,
            'messageType' => $messageType,
        ]);
    }
}
