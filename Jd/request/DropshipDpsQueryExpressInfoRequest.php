<?php
class DropshipDpsQueryExpressInfoRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.dropship.dps.queryExpressInfo";
	}
	
	public function getApiParas(){
		return json_encode($this->apiParas);
	}
	
	public function check(){
		
	}
	
	public function putOtherTextParam($key, $value){
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
                                                        		                                    	                   			private $pin;
    	                        
	public function setPin($pin){
		$this->pin = $pin;
         $this->apiParas["pin"] = $pin;
	}

	public function getPin(){
	  return $this->pin;
	}

                        	                   	                    		private $customOrderIds;
    	                        
	public function setCustomOrderIds($customOrderIds){
		$this->customOrderIds = $customOrderIds;
         $this->apiParas["customOrderIds"] = $customOrderIds;
	}

	public function getCustomOrderIds(){
	  return $this->customOrderIds;
	}

                            }





        
 

