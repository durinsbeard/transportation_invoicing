select weight, 
	   gross_amount,
	   shipper_state
from dayton as car
join 
(select min_weight,max_weight,min_val, max_val,carrier_id from min_max) 
as mm on car.weight not between mm.min_weight and mm.max_weight
and car.gross_amount not between mm.min_val and mm.max_val
left join 
(select carrier_id, carrier_name from carriers) as carriers 
on mm.carrier_id = carriers.carrier_id
left join 
(select carrier_id,customer_id,state_id from carriers_customers_states) as ccs
on carriers.carrier_id = ccs.carrier_id
left join (select state_id, state_abrv from states) as states 
on ccs.state_id <> states.state_id
order by gross_amount desc