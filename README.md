A simple API with:
-POST /invoices:
    . It receives invoice payload 
    . calculate the tax
    . calculate total
    . store record in database
-GET /invoices:
    . fetch list of invoices 
    . output the total number of the invoices existing on the database
    . calculate the total invoice amount

Application is scaled to use 2 Databases to configure:
    -modify ./config/database.php : change CHANGE_TO_SLAVE_DB_IP_ADDRESS and CHANGE_TO_MASTER_DB_IP_ADDRESS to your slave DB and Master DB IP Address respectively
    -modify ./env : comment out the line DB_HOST_SLAVE=127.0.0.1

N.B: A postman collection is exported for api test purpose ./invoices.postman_collection.json