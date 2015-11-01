<?php
namespace Mgazelle\Ideal;

class Ideal extends Transaction
{

  public function __construct($paymentDetails = NULL)
  {
      parent::__construct( $paymentDetails );
  }
  
  /**
  * @Desc start payment
  * @Return array ( trxid, idealReturnUrl )
  */
  
    public function startPayment ()
    {
        if ($this->paymentDetails['amount'] > self::MAX_AMOUNT) throw new \Exception('Amount is larger than the maximum amount');
        if ($this->paymentDetails['amount'] < self::MIN_AMOUNT) throw new \Exception('Amount is smaller than the minimum amount');

        $aParameters = $this->paymentDetails;

        $strResponse = $this->getResponse( $aParameters, 'https://www.targetpay.com/ideal/start?');

        $aResponse = explode('|', $strResponse );

        if (!isset($aResponse[1])) {
            throw new \Exception('Error' . $aResponse[0]);
        }

        $iTrxID = explode ( ' ', $aResponse[0] );

        return array ($iTrxID[1], $aResponse[1]);
  }

    /**
     * @param $paymentDetails
     * @return bool
     * @throws \Exception
     */
    public function validatePayment ($paymentDetails)
    {
        $aParameters['test'] = 0;
        $aParameters['once'] = 1;

        $aParameters = $paymentDetails;

        $strResponse = $this->getResponse ( $aParameters , 'https://www.targetpay.com/ideal/check?');
        $aResponse = explode('|', $strResponse );

        //Bad response
        if (  $aResponse[0] != '000000 OK' ) {
            throw new \Exception( $aResponse[0] );
        }

        return true;
   }
  
}