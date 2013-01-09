alter table products add short_description text;
alter table products add short_who text;
alter table products add short_how text;
update products set short_description=description,short_how=how,short_who=who;

alter table organizations add short_profile text;

alter table organizations add short_product_how text;

 update organizations set short_profile=profile,short_product_how=product_how;