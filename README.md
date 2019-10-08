# patanjali-store-database-structure
**products**
	- id
	- name
	- bar code
	- batch
	- tax

**batch**
	- product id
	- mrp
	- qty
	- avg cost price

**product sales**
	- inv id
	- product id
	- batch
	- mrp
	- sale_date
	- qty

invoices
	- id
	- no of products
	- total units
	- total
	- discount
	- discount in percent
	- grand total
	- profit
	- type
	- payment mode

invoice product
	- invoice id
	- product name
	- product id
	- batch id
	- qty
	- avg_cost
	- mrp
	- discount
	- discount in percent
	- product total
	- product profit
	- type