CREATE TABLE tx_products_domain_model_product (
    article_number varchar(255),
    title varchar(255),
    description text,
    slug varchar(255),
    images int(11) unsigned DEFAULT '0' NOT NULL,
);
