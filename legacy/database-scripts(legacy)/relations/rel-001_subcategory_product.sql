-- this script is run after the structure scripts                      --
-- so the tables are already created                                   --
-- and the is not any collission or error caused due to missing tables --

-- fk_category_product_subcategory
alter table tbsubcategoryproduct
    add constraint fk_category_product_subcategory 
        foreign key (idcategoryproduct) 
        references tbproductcategory(idproductcategory);