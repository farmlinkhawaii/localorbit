ALTER TABLE organizations
  MODIFY org_id int(10) NOT NULL;
ALTER TABLE organizations
  ENGINE = InnoDB;




ALTER TABLE payables
	ADD CONSTRAINT payables_from_org_id_fk
	FOREIGN KEY (from_org_id)
	REFERENCES organizations (org_id) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
ALTER TABLE payables
	ADD CONSTRAINT payables_to_org_id_fk
	FOREIGN KEY (to_org_id)
	REFERENCES organizations (org_id) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
    
ALTER TABLE domains
  ENGINE = InnoDB;    
ALTER TABLE domains
  MODIFY domain_id int(10) AUTO_INCREMENT NOT NULL;
ALTER TABLE payables
	ADD CONSTRAINT payables_domain_id_fk
	FOREIGN KEY (domain_id)
	REFERENCES domains (domain_id) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
  
ALTER TABLE payables
	ADD CONSTRAINT payables_invoice_id_fk
	FOREIGN KEY (invoice_id)
	REFERENCES invoices (invoice_id) ON DELETE RESTRICT ON UPDATE RESTRICT;
        
    
ALTER TABLE lo_order_line_item
  MODIFY lo_liid int(10) AUTO_INCREMENT NOT NULL;    
    
ALTER TABLE payables
	ADD CONSTRAINT payables_parent_obj_id_fk
	FOREIGN KEY (parent_obj_id)
	REFERENCES lo_order_line_item (lo_liid) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
    
    
    
ALTER TABLE lo_order_line_item
  MODIFY lodeliv_id int(10);
ALTER TABLE lo_order_deliveries
  MODIFY lodeliv_id int(10) NOT NULL;  
ALTER TABLE lo_order_line_item
	ADD CONSTRAINT llo_order_line_item_lodeliv_id_fk
	FOREIGN KEY (lodeliv_id)
	REFERENCES lo_order_deliveries (lodeliv_id) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
    
    
    
    
    
**********************************************************
    do these
    
ALTER TABLE lo_order_line_item
	ADD CONSTRAINT lo_order_line_item_lo_oid_fk
	FOREIGN KEY (lo_oid)
	REFERENCES lo_order (lo_oid) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE lo_fulfillment_order
  MODIFY lo_foid int(10) AUTO_INCREMENT NOT NULL;
 ALTER TABLE lo_order_line_item
  MODIFY lo_foid int(10) NOT NULL;

ALTER TABLE lo_delivery_statuses
  ENGINE = InnoDB;
ALTER TABLE lo_order
  MODIFY ldstat_id int(10);
ALTER TABLE lo_delivery_statuses
  MODIFY ldstat_id int(10) AUTO_INCREMENT NOT NULL; 
ALTER TABLE lo_order
	ADD CONSTRAINT lo_order_ldstat_id_fk
	FOREIGN KEY (ldstat_id)
	REFERENCES lo_delivery_statuses (ldstat_id) ON DELETE RESTRICT ON UPDATE RESTRICT;
	
	
********************************************************** bad data 0s on lo_order_line_item.lo_foid
ALTER TABLE lo_order_line_item
  MODIFY lo_foid int(10);
  
ALTER TABLE lo_order_line_item
	ADD CONSTRAINT lo_order_line_item_lo_foid_fk
	FOREIGN KEY (lo_foid)
	REFERENCES lo_fulfillment_order (lo_foid) ON DELETE RESTRICT ON UPDATE RESTRICT;
    

    
    

**********************************************************






  
 ALTER TABLE lo_fulfillment_order_status_changes  ENGINE = InnoDB; 
  ALTER TABLE lo_fulfillment_order_status_changes
  MODIFY lo_foid int(10);
  
  DELETE FROM lo_fulfillment_order_status_changes
WHERE NOT lo_foid IN (SELECT lo_foid FROM lo_fulfillment_order);
  
  
  
  ALTER TABLE lo_order_delivery_fees
  MODIFY fee_type varchar(255);

ALTER TABLE lo_order_delivery_fees
  MODIFY fee_calc_type_id int;

ALTER TABLE lo_order_delivery_fees
  MODIFY amount decimal(10,2) DEFAULT '0';
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
ALTER TABLE lo_fulfillment_order_status_changes
  MODIFY lo_foid int(10) UNSIGNED;
  
ALTER TABLE lo_fulfillment_order_status_changes
  ADD CONSTRAINT lo_fulfillment_order_status_changes_fk1
  FOREIGN KEY (lo_foid)
    REFERENCES lo_fulfillment_order(lo_foid)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
  
  
  
  
  

ALTER TABLE invoice_send_dates
  ADD CONSTRAINT invoice_send_dates_invoice_id_fk
  FOREIGN KEY (invoice_id)
    REFERENCES invoices(invoice_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE organizations
  ENGINE = InnoDB;
ALTER TABLE organizations
  MODIFY org_id int(10) NOT NULL;


-----------------------------


ALTER TABLE lo_order_line_item
  ADD CONSTRAINT lo_order_line_item_lo_foid_fk
  FOREIGN KEY (lo_foid)
    REFERENCES lo_fulfillment_order(lo_foid)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;



ALTER TABLE lo_order
  ADD CONSTRAINT lo_order_org_id_fk
  FOREIGN KEY (org_id)
    REFERENCES organizations(org_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE domains
ENGINE = InnoDB;

ALTER TABLE lo_order
MODIFY domain_id int(10);


**9****** these might be empty carts
	ALTER TABLE lo_order
	  ADD CONSTRAINT lo_order_domain_id_fk
	  FOREIGN KEY (domain_id)
	    REFERENCES domains(domain_id)
	    ON DELETE RESTRICT
	    ON UPDATE RESTRICT;



ALTER TABLE organizations_to_domains
  ADD CONSTRAINT organizations_to_domains_domain_id_fk
  FOREIGN KEY (domain_id)
    REFERENCES domains(domain_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;



ALTER TABLE organizations_to_domains
  ADD CONSTRAINT organizations_to_domains_org_id_fk
  FOREIGN KEY (org_id)
    REFERENCES organizations(org_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE lo_delivery_statuses
  ENGINE = InnoDB;

ALTER TABLE lo_order_line_item
  ADD CONSTRAINT lo_order_line_item_ldstat_id_fk
  FOREIGN KEY (ldstat_id)
    REFERENCES lo_delivery_statuses(ldstat_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;



ALTER TABLE lo_buyer_payment_statuses
  ENGINE = InnoDB;

ALTER TABLE lo_order_line_item
  ADD CONSTRAINT lo_order_line_item_lbps_id_fk
  FOREIGN KEY (lbps_id)
    REFERENCES lo_buyer_payment_statuses(lbps_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE lo_seller_payment_statuses
  ADD CONSTRAINT lo_seller_payment_statuses_lsps_id_fk
  FOREIGN KEY (lsps_id)
    REFERENCES lo_seller_payment_statuses(lsps_id)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;




************************************
DELETE FROM addresses WHERE org_id IS null;
ALTER TABLE addresses  ENGINE = InnoDB;
ALTER TABLE addresses  MODIFY org_id int(10);
			
ALTER TABLE addresses
ADD CONSTRAINT addresses_org_id
FOREIGN KEY (org_id)
REFERENCES organizations(org_id)
ON DELETE RESTRICT
ON UPDATE RESTRICT;











