ALTER TABLE up_order DROP foreign key up_order_ibfk_2;
ALTER TABLE up_order DROP INDEX FK_ORDER_ITEM;
ALTER TABLE up_order DROP ITEM_ID;

CREATE TABLE up_order_item
(
    ID int not null auto_increment,
    ORDER_ID int not null,
    ITEM_ID int not null,
    QTY int not null,
    TITLE varchar(255) not null,
    PRICE float not null,

    PRIMARY KEY (ID),
    FOREIGN KEY FK_OI_ORDER (ORDER_ID)
        REFERENCES up_order(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    FOREIGN KEY FK_OI_ITEM (ITEM_ID)
        REFERENCES up_item(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
)
    engine = innodb
    auto_increment = 1
    character set utf8
    collate utf8_general_ci;