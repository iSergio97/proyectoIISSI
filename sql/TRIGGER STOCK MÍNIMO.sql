CREATE OR REPLACE TRIGGER STOCK_MINIMO
before
UPDATE ON TIENESTOCKEN
FOR EACH ROW
DECLARE V_STOCK NUMBER;
V_IDARTICULO NUMBER;
BEGIN
SELECT (STOCK) INTO V_STOCK FROM TIENESTOCKEN WHERE IDARTICULO = V_IDARTICULO;
IF(V_STOCK < 5) THEN 
raise_application_error (-95361, 'El stock del artículo' || v_idArticulo || 'es menor de 5, debería realizar un pedido de dicho artículo');
end if;
end;