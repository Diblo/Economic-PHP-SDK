<?php namespace tkj\Economics\Product;

use tkj\Economics\Client;

class Currency {

    /**
     * Client Connection
     * @var devdk\Economics\Client
     */
    protected $client;

    /**
     * Construct class and set dependencies
     * @param devdk\Economics\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client     = $client->getClient();
    }

   /**
     * Returns a handle for the product price for a given product and currency
     * @param  string $number
     * @param  string $code
     * @return object
     */
    private function findByProductAndCurrency($number, $code)
    {
        return $this->client
            ->ProductPrice_FindByProductAndCurrency(array('productHandle'=>array('Number'=>$number), 'currencyHandle'=>array('Code'=>$code)))
            ->ProductPrice_FindByProductAndCurrencyResult;
    }

    /**
     * Get the price of a product by currency code
     * @param  string $number
     * @param  string $code
     * @param  float $value
     * @return object
     */
    public function create($number, $code, $value)
    {
		return $this->client->ProductPrice_Create(
			array(
				'productHandle' => array('Number' => $number),
				'currencyHandle' => array('Code' => $code),
				'Price' => $values
			)
		)->ProductPrice_CreateResult;
    }

    /**
     * Get the price of a product by currency code
     * @param  string $number
     * @param  string $code
     * @return float
     */
    public function get($number, $code)
    {
		$handler = $this->FindByProductAndCurrency($number, $code);
		return (float) $this->client->ProductPrice_GetPrice(array('productPriceHandle' => $handler))->ProductPrice_GetPriceResult;
    }

    /**
     * Sets the price of a product price
     * @param  string $number
     * @param  string $code
     * @param  float $value
     * @return boolean
     */
    public function update($number, $code, $value)
    {
        try {
			$handler = $this->FindByProductAndCurrency($number, $code);
			$this->client->ProductPrice_SetPrice(array('productPriceHandle' => $handler, 'value' => $value));
        } catch( Exception $e ) {
            return false;
        }

        return true;
    }

    /**
     * Deletes a product price
     * @param  string $number
     * @param  string $code
     * @return boolean
     */
    public function delete($number, $code)
    {
        try {
			$handler = $this->FindByProductAndCurrency($number, $code);
			return $this->client->ProductPrice_Delete(array('productPriceHandle' => $handler));
        } catch( Exception $e ) {
            return false;
        }

        return true;
    }

     /**
     * Creates new product prices from data objects
     * @param  array $numbers
     * @param  array $codes
     * @param  array $values
     * @return object
     */
    public function createFromData(array $numbers, array $codes, array $values)
    {
		if ( count($numbers) == 1 )
		{
			$handler = $this->FindByProductAndCurrency($numbers[0], $codes[0]);
			return $this->client->ProductPrice_CreateFromData(
					array('data'=>
						array(
							'Handle' => $handler,
							$handler,
							'ProductHandle' => array('Number' => $numbers[0]),
							'CurrencyHandle' => array('Code' => $codes[0]),
							'Price' => $values[0]
						)
					)
				)->ProductPrice_CreateFromDataResult;
		}

		$request = array();
		foreach ( $numbers as $key => $number )
		{
			$handler = $this->FindByProductAndCurrency($number, $codes[$key]);
			$request[] = array(
							'Handle' => $handler,
							$handler,
							'ProductHandle' => array('Number' => $number),
							'CurrencyHandle' => array('Code' => $codes[$key]),
							'Price' => $values[$key]
						)
		}
		return $this->client->ProductPrice_CreateFromDataArray(array('dataArray' => 'ProductPriceData' => $request))->ProductPrice_CreateFromDataArrayResult;
	}

    /**
     * Updates a product price from a data object
     * @param  array $numbers
     * @param  array $codes
     * @param  array $values
     * @return object
     */
    public function updateFromData(array $numbers, array $codes, array $values)
    {
		if ( count($numbers) == 1 )
		{
			$handler = $this->FindByProductAndCurrency($numbers[0], $codes[0]);
			return $this->client->ProductPrice_UpdateFromData(
					array('data' =>
						array(
							'Handle' => $handler,
							$handler,
							'ProductHandle' => array('Number' => $numbers[0]),
							'CurrencyHandle' => array('Code' => $codes[0]),
							'Price' => $values[0]
						)
					)
				)->ProductPrice_UpdateFromDataResult;
		}

		$request = array();
		foreach ( $numbers as $key => $number )
		{
			$handler = $this->FindByProductAndCurrency($number, $codes[$key]);
			$request[] = array(
							'Handle' => $handler,
							$handler,
							'ProductHandle' => array('Number' => $number),
							'CurrencyHandle' => array('Code' => $codes[$key]),
							'Price' => $values[$key]
						)
		}
		return $this->client->ProductPrice_UpdateFromDataArray(array('dataArray' => array('ProductPriceData' => $request)))->ProductPrice_UpdateFromDataArrayResult;
	}
}