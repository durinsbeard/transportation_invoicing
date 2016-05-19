select weight, 
	   gross_amount,
	   shipper_state
from dayton as thedata
join 
(select min_weight,max_weight,min_val, max_val,carrier_id from min_max) 
as mm on thedata.weight not between mm.min_weight and mm.max_weight
and thedata.gross_amount not between mm.min_val and mm.max_val
left join 
(select carrier_id, carrier_name from carriers) as carriers 
on mm.carrier_id = carriers.carrier_id
left join 
(select carrier_id,customer_id, from carriers_customers) as cc
on carriers.carrier_id = cc.carrier_id
left join (select state_id, state_abrv from states) as states 
on ccs.state_id <> states.state_id
order by gross_amount desc
