<?php
namespace Mgazelle\Ideal;
  
abstract class Transaction
{
    const MIN_AMOUNT = 94;
    const MAX_AMOUNT = 1000000;

   /**
   * @var array payment details
   */
    protected $paymentDetails;

    /**
     * @param $paymentDetails
     */
    public function __construct($paymentDetails)
    {
        $this->setPaymentDetails($paymentDetails);
    }

    abstract public function startPayment();
    
   /**
   * Get response for a targetpay request
   * 
   * @param array $aParams
   * @return string
   */
   
    protected function getResponse($aParams, $sRequest = 'https://www.targetpay.com/api/plugandpay?')
    {
        $strParamString = $this->makeParamString( $aParams );
        //die($sRequest.$strParamString);

        $strResponse = file_get_contents($sRequest.$strParamString);

        return $strResponse;
    }
     
   /**
   * Make string from params
   * 
   * @param array $aParams
   * @return string
   */
   
   protected function makeParamString($aParams)
   {
        $strString = '';
        foreach ($aParams as $strKey => $strValue)
          $strString .= '&' . urlencode($strKey) . '=' . urlencode($strValue);
        
        # remove first &  
        return substr($strString , 1);
    }
    
    /**
    * Get the base request with IP, RTLO, domain,
    * 
    * @return array
    */
    protected function getBaseRequest()
    {
        $aParams['action'] = 'start';
        $aParams['ip'] = $_SERVER['REMOTE_ADDR'];
        $aParams = $this->paymentDetails;

        return $aParams;
    }

    /**
    * @desc set payment details
    * @Var array payment details
    */
    
    public function setPaymentDetails ($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;   
    }   
}