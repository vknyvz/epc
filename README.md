
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
    
#### SQL Questions

1. What is SQL?
   A tool for us to use to communicate with a database. SQL is also a standard query language for relational databases.
   
2. What is RDBMS?
   Database management system.
   
3. What is Data Mining?
   Data mining is the process of discovering patterns in large data sets involving methods at the intersection of machine learning, statistics, and database systems.
   
4. What is an ERD?
   Entity Relationship Diagram. 
   An entity relationship diagram is a specialized graphic that illustrates the relationships between entities in a database

5. What is the difference between Primary Key and Unique Key?
   Primary Key is used to identify a row, whereas Unique-key is to prevent duplicate values in a column.
    
6. How can you store a picture file in the database? What Object type is used?
   Blob types can be used to insert a file in a dB

7. What is Data Warehousing?

8. What are indexes in a Database?
   A database index is a data structure that improves the speed of data retrieval operations on a database table at the cost of additional writes and storage space to maintain the index data structure

9. How many Triggers are possible in MySQL? (Explain them all)
    Before Insert
    After Insert
    Before Update
    After Update
    Before Delete
    After Delete
    
    Enforce business rules
    Validate input data
    Generate a unique value for a newly-inserted row in a different file.
    Write to other files for audit trail purposes
    Query from other files for cross-referencing purposes
    Access system functions
    Replicate data to different files to achieve data consistency

10. What is Heap table?
   Heap tables are tables without a Clustered Index. A table in SQL Server can have a Clustered Index, then it’s called a Clustered Table, and without a Clustered Index, it’s called a Heap Table. Heap tables are very, very, very fast – for inserting data.
   
11. Define the common MySQL storage engines and explain their differences.
   InnoDB and MyISAM
   InnoDB: A transaction-safe (ACID compliant) storage engine for MySQL that has commit, rollback, and crash-recovery capabilities to protect user data. InnoDB row-level locking (without escalation to coarser granularity locks) and Oracle-style consistent nonlocking reads increase multi-user concurrency and performance. InnoDB stores user data in clustered indexes to reduce I/O for common queries based on primary keys. To maintain data integrity, InnoDB also supports FOREIGN KEY referential-integrity constraints. InnoDB is the default storage engine in MySQL 5.6.
   MyISAM: These tables have a small footprint. Table-level locking limits the performance in read/write workloads, so it is often used in read-only or read-mostly workloads in Web and data warehousing configurations.