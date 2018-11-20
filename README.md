# AsgardCMS E-Commerce Module


### Email Configurations Backend

	1. Go to Settings
	2. Click on Icommerce
	3. Edit "Sender Email" and "Webmaster Email"


### Email Configurations Files

	Perform the following processes for both Themes (Imagina2018 and Adminlte)

	Instructions: 
		1. Copy the file "plantilla.blade" in views/email
		2. Copy the folder "email" in assets/img/email


##Api
1- filters for products :

```php
api/icommerce/v2/products?filters={"categories":1,"recient":true,"take":5,"order":{"by":"slug","type":"asc"}}
```