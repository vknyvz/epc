
#### Installation

    - Clone 
    - Run `composer install` 
    - Setup dB with;
        - php bin/console doctrine:database:create
        - php bin/console doctrine:schema:update --force
    - Load some data 
        - php bin/console doctrine:fixtures:load

#### Command

    - php bin/console app:products-pending

#### Routes

    - get_customers GET      /api/customers/
    - get_customer GET       /api/customers/{id}
    - create_customer POST   /api/customers/
    - update_customer PUT    /api/customers/{id}
    - delete_customer DELETE /api/customers/{id}
    - customer_index GET     /customers/
    - customer_new GET|POST  /customers/new
    - customer_show GET      /customers/{uuid}
    - customer_edit GET|POST /customers/{uuid}/edit
    - customer_delete DELETE /customers/{uuid}
    - get_Products GET       /api/products/
    - get_Product GET        /api/products/{id}
    - create_product POST    /api/products/
    - update_product PUT     /api/products/{id}
    - delete_product DELETE  /api/products/{id}
    - product_index GET      /products/
    - product_new GET|POST   /products/new
    - product_show GET       /products/{issn}
    - product_edit GET|POST  /products/{issn}/edit
    - product_delete DELETE  /products/{issn}
    