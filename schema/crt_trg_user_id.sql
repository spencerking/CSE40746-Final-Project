create trigger trg_user_id
before insert on domer
for each row
begin
select user_id_seq.nextval
into :new.user_id
from dual;
end;
/