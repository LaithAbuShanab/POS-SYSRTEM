# Point Of Sales API

Response schema: JSON Object {
"success": boolean,
"message_code": string,
"body": Array
}

GET /selling

- Fetches all items from stocks
- Request Arguments: None
- 404 will be returned if no item was found

GET /transaction/sellers

- Fetches all transactions from transactions table
- Request Arguments: None
- 404 will be returned if no transaction was found

POST /sellers/create

- creates new transaction
- Request Arguments: {"item_name": string ,"quantity": integer ,"total": integer}
- 422 will be returned if item_name param was not found
- 422 will be returned if quantity param was not found
- 422 will be returned if total param was not found

PUT /sellers/update

- Updates the sold quantity of the item
- Request Arguments: {"id": integer,"quantity": integer}
- 422 will be returned if id param was not found
- 422 will be returned if quantity param was not found
- 404 will be returned if no item was found

PUT /sellers/update/transaction

- Updates the current transaction amount and the quantity in the stock
- Request Arguments: {"id": integer,"quantity": integer,"item_id: integer"}
- 422 will be returned if id param was not found
- 422 will be returned if quantity param was not found
- 404 will be returned if no transaction was found

DELETE /sellers/delete

- deletes the current transaction amount
- Request Arguments: {"id": integer}
- 422 will be returned if id param was not found