<?php
define("DEVELOPMENT","mark");

use Garden\Cli\Cli;

// require composer's autoloader.
require_once 'vendor/autoload.php';

// define the cli options.
$cli = new Cli();

$cli = Cli::create()
	->description('make real money change for a transaction.')
	->opt('price:p', 'Price of the item.', true)
	->opt('tendered:t', 'Amount of money presented to pay for the item.', true);

// Parse and return cli arg
$args = $cli->parse($argv, true);
$price = 13.43;
$paid = 44;
$price = floatval($args->getOpt('price', true));
$paid  = floatval($args->getOpt('tendered', true));

//
//  i like having a utility function class under my models to hold "global" class function that will
//  be needed for all models...in this case "model functions" does the trick
//
class cashier_model  {

	const LABEL = 0, AMT = 1, CNT = 2;

	public $cash_array;
	private $total_cost;
	private $amount_provided;

	public function __construct() {

		// init class members
		$this->cash_array       =   [
										["Hundred Dollar Bill",10000,-1 ],
										["Fifty Dollar Bill", 5000, -1],
										["Twenty Dollar Bill", 2000, -1],
										["Ten Dollar Bill", 1000, -1],
										["Five Dollar Bill", 500, -1],
										["One Dollar Bill", 100, -1],
										["Quarter", 25, -1],
										["Dime", 10, -1],
										["Nickle", 5, -1],
										["Penny", 1, -1]
									];

		$this->total_cost       = 0.0;
		$this->amount_provided  = 0.0;

	}

	public function load_cost_and_provided($cost,$provided) {

		$rv = [];
		$rv['status']=true;

		if ($cost < 0.0) {
			$rv['status']=false;
			$rv['msg']="ERROR - We have to pay YOU for the item?  That's not how it works...";
		}

		if ($provided < 0.0 ) {
			$rv['status']=false;
			$rv['msg']="ERROR - We don't accept credit here...";
		}

		if ($provided < $cost) {
			$rv['status']=false;
			$rv['msg']="ERROR - Well I can't make change if you don't give me more then the item cost, can I?";
		}


		$this->total_cost = $cost;
		$this->amount_provided = $provided;
		return $rv;

	}

	public function calc_change() {

		$change_in_pennies = intval(($this->amount_provided - $this->total_cost) *100);

		// this loop calcs the correct change automagically
		foreach ($this->cash_array as &$denom) {

			$amt = $denom[self::AMT];
			$how_many =  intval( $change_in_pennies / $amt);
			if ($how_many > 0) {
				$change_in_pennies -= $how_many * $amt;
				$denom[self::CNT] = $how_many;
			}
		}

		return $this->cash_array;
	}

}

$cashier = new cashier_model();

$rv=$cashier->load_cost_and_provided($price,$paid);

if ($rv['status']) {

	$change = $cashier->calc_change();
	echo "Calculating change For $$paid for the price $$price\n\n";
	foreach ($change as $bill) {
		if ($bill[cashier_model::CNT] > 0) {
			echo $bill[cashier_model::CNT]. " ".$bill[cashier_model::LABEL] .  ($bill[cashier_model::CNT]>1?"s":"") . "\n" ;
		}
	}
}
else {
	echo $rv['msg']."\n";
	exit;
}