-- this script is run after the structure scripts                      --
-- so the tables are already created                                   --
-- and the is not any collission or error caused due to missing tables --

-- fk_product_subcategory
alter table tbproduct
    add constraint fk_product_subcategory_product
        foreign key (idsubcategory)
        references tbsubcategoryproduct(idsubcategoryproduct);

