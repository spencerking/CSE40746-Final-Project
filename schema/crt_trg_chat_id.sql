create trigger trg_chat_id
before insert on chat
for each row
begin
select chat_id_seq.nextval
into :new.chat_id
from dual;
end;
/