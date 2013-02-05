<?php
class core_model_organization_payment_methods extends core_model_base_organization_payment_methods
{

}

function organization_payment_methods__formatter_dropdown($data)
{
	$data['dropdown_text']  = 'ACH: '.$data['name_on_account'];
	$data['dropdown_text'] .= ' - *********'.$data['nbr1_last_4'];
	return $data;
}

class CompanyInfo {
	public $SSS;
	public $LocID;
	public $Company;
	public $CompanyKey;
}

class  InpACHTransRecord{
	public $SSS;
	public $LocID;
	public $FrontEndTrace;
	public $CustomerName;
	public $CustomerRoutingNo;
	public $CustomerAcctNo;
	public $CompanyKey;
}
?>