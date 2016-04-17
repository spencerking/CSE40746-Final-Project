create trigger trg_item_id
before insert on item
for each row
begin
select item_id_seq.nextval
into :new.item_id
from dual;
end;
/