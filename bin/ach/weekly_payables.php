#!/usr/bin/php
<?php
define('__CORE_ERROR_OUTPUT__','exit');
include(dirname(__FILE__).'/../../www/app/core/core.php');
core::init();
core::load_library('crypto');

$actually_do_payment = $argv[1] == 'yes';

if($actually_do_payment)
	echo("REALLY DOING IT\n");


$sql = '
	select group_concat(p.payable_id) as payables,group_concat(i.invoice_id) as invoices,sum(COALESCE(
		 (select sum(xip.amount_paid) - p.amount 
		 from x_invoices_payments xip
		 where xip.invoice_id=i.invoice_id), p.amount
	)) as amount_due,o.org_id
	from payables p
	inner join invoices i on (p.invoice_id=i.invoice_id)
	inner join domains d on d.domain_id=p.domain_id
	inner join organizations o on (i.to_org_id=o.org_id)
	
	where payable_type_id=2
	and COALESCE(
		 (select sum(xip.amount_paid) - p.amount 
		 from x_invoices_payments xip
		 where xip.invoice_id=i.invoice_id), p.amount
	) > 0
	group by o.org_id

';

$invoices = new core_collection($sql);

foreach($invoices as $invoice)
{
	echo('need to pay '.$invoice['invoices'].': '.$invoice['amount_due']."\n");
	
	
}

exit("complete!\n");
?>