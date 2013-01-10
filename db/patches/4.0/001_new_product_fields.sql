alter table products add short_description text;

update products set short_description=description;