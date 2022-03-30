CREATE TABLE IF NOT EXISTS versions
(
    id int(10) unsigned not null auto_increment,
    name varchar(255) not null,
    created timestamp default current_timestamp,
    primary key (id)
)
    engine = innodb
    auto_increment = 1
    character set utf8
    collate utf8_general_ci;

CREATE TABLE up_item
(
    ID int not null auto_increment,
    NAME varchar(500) not null,
    PRICE float not null,
    SHORT_DESC text not null,
    FULL_DESC text not null,
    SORT_ORDER int,
    ACTIVE bool,
    CREATION_DATE timestamp default current_timestamp,
    EDITING_DATE timestamp default current_timestamp,

    PRIMARY KEY (ID)
);

CREATE TABLE up_status
(
    ID int not null auto_increment,
    NAME varchar(500) not null,

    PRIMARY KEY (ID)
);

CREATE TABLE up_order
(
    ID int not null auto_increment,
    ITEM_ID int not null,
    STATUS_ID int not null,
    EMAIL varchar(320),
    PHONE varchar(11),
    COMMENT text,
    CREATION_DATE datetime,
    EDITING_DATE datetime,

    PRIMARY KEY (ID),
    FOREIGN KEY FK_ORDER_STATUS (STATUS_ID)
        REFERENCES up_status(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

CREATE TABLE up_image
(
    ID int not null auto_increment,
    PATH text not null,
    WIDTH int not null,
    HEIGHT int not null,

    PRIMARY KEY (ID)
);

CREATE TABLE up_item_image
(
    ITEM_ID int not null,
    IMAGE_ID int not null,

    FOREIGN KEY FK_II_ITEM (ITEM_ID)
        REFERENCES up_item(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    FOREIGN KEY FK_II_IMAGE (IMAGE_ID)
        REFERENCES up_image(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

CREATE TABLE up_category
(
    ID int not null auto_increment,
    NAME varchar(500) not null,

    PRIMARY KEY (ID)
);

CREATE TABLE up_item_category
(
    ITEM_ID int not null,
    CATEGORY_ID int not null,

    FOREIGN KEY FK_IC_ITEM (ITEM_ID)
        REFERENCES up_item(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    FOREIGN KEY FK_IC_CATEGORY (CATEGORY_ID)
        REFERENCES up_category(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

CREATE TABLE up_attributes
(
    ID int not null auto_increment,
    NAME varchar(500) not null,
    CATEGORY_ID int not null,

    PRIMARY KEY (ID),
    FOREIGN KEY FK_ATTRIBUTES_CATEGORY (CATEGORY_ID)
        REFERENCES up_category(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

CREATE TABLE up_additional_characteristics
(
    ID int not null auto_increment,
    NAME varchar(500) not null,
    ITEM_ID int not null,
    ATTRIBUTES_ID int not null,

    PRIMARY KEY (ID),
    FOREIGN KEY FK_AC_ITEM (ITEM_ID)
        REFERENCES up_item(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    FOREIGN KEY FK_AC_ATTRIBUTES (ATTRIBUTES_ID)
        REFERENCES up_attributes(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);