USE mysqlPractice;

# Write a statement that will select the City column from the Customers table.
SELECT City
FROM customers;

# Select all the different values from the Country column in the Customers table.
SELECT DISTINCT Country
FROM customers;

# Select all records where the City column has the value "Berlin".
SELECT *
FROM customers
WHERE City = 'Berlin';

# Use the NOT keyword to select all records where City is NOT "Berlin".
SELECT *
FROM customers
WHERE NOT City = 'Berlin';

# Select all records where the City column has the value 'Berlin' and the PostalCode column has the value 12209.
SELECT *
FROM customers
WHERE City = 'Berlin'
  AND PostalCode = '12209';

# Select all records from the Customers table, sort the result reversed alphabetically by the column City.
SELECT *
FROM customers
ORDER BY City;

# Select all records from the Customers table, sort the result alphabetically, first by the column Country, then, by the column City.
SELECT *
FROM customers
ORDER BY Country, City;

# Insert a new record in the Customers table.
INSERT INTO customers (customername, contactname, address, city, postalcode, country)
VALUES ('Dorito', 'Some Tako', '5th Avenue 44', 'Some City', 22332, 'SRE');


# Select all records from the Customers where the PostalCode column is empty.
SELECT *
FROM customers
WHERE PostalCode = '';

#     Select all records from the Customers where the PostalCode column is NOT empty.
SELECT *
FROM customers
WHERE NOT PostalCode = '';

#     Set the value of the City columns to 'Oslo', but only the ones where the Country column has the value "Norway".
UPDATE customers
SET City = 'Oslo'
WHERE Country = 'Norway';

#     Update the City value and the Country value.
UPDATE customers
SET City    = 'Oslo1',
    Country = 'Norway1'
WHERE CustomerID = 70;

#     Delete all the records from the Customers table where the Country value is 'Norway'.
SET FOREIGN_KEY_CHECKS = 0;
DELETE
FROM customers
WHERE Country = 'Norway1';
SET FOREIGN_KEY_CHECKS = 1;


#     Delete all the records from the Customers table.
DELETE
FROM customers;

#     Select all records where the value of the City column contains the letter "a".
SELECT *
FROM customers
WHERE City LIKE '%a%';

#     Select all records where the value of the City column ends with the letter "a".
SELECT *
FROM customers
WHERE City LIKE '%a';

#     Select all records where the value of the City column starts with letter "a" and ends with the letter "b".
SELECT *
FROM customers
WHERE City REGEXP '^a[a-zA-Z]+b$';

#     Select all records where the value of the City column does NOT start with the letter "a".
SELECT *
FROM customers
WHERE City NOT LIKE 'a%';

# Use the IN operator to select all the records where Country is NOT "Norway" and NOT "France".
SELECT *
FROM customers
WHERE Country NOT IN ('Norway', 'France');

# Use the IN operator to select all the records where Country is either "Norway" or "France".
SELECT *
FROM customers
WHERE Country IN ('Norway', 'France');

# Use the BETWEEN operator to select all the records where the value of the Price column is NOT between 10 and 20.
SELECT *
FROM products
WHERE Price BETWEEN 10 AND 20;

# Use the BETWEEN operator to select all the records where the value of the ProductName column is alphabetically between 'Geitost' and 'Pavlova'.
SELECT *
FROM products
WHERE ProductName BETWEEN 'Geitost' AND 'Pavlova';

# Choose the correct JOIN clause to select all the records from the Customers table plus all the matches in the Orders table.
SELECT *
FROM customers c
         LEFT JOIN orders
                   USING (CustomerID);

# Choose the correct JOIN Find out the number of orders made for each city (city) from the Customers table.
SELECT City, COUNT(orders.OrderID) as TotalPerCity
FROM orders
         JOIN customers
              USING (CustomerID)
GROUP BY City
ORDER BY City;

# Choose the correct JOIN Find out the total cost of orders for the user.
SELECT CustomerID, CustomerName, SUM(Price * Quantity) as TotalPrice
FROM customers
         LEFT JOIN orders
                   USING (CustomerID)
         LEFT JOIN order_details
                   USING (OrderID)
         LEFT JOIN products
                   USING (ProductID)
GROUP BY CustomerID
ORDER BY CustomerID;

# Choose the correct JOIN  From the (Product) table, display only those products that have a Supplier:
# New Orleans Cajun Delights (2) or Tokyo Traders (4) and add the SupplierName to the product output
SELECT ProductName, SupplierName
FROM products
         JOIN suppliers
              USING (SupplierID)
WHERE SupplierID IN (4, 2)
ORDER BY ProductName;

# Choose the correct JOIN Display the average amount of all orders for each date (OrderDate) in the (Orders) table,
# if the average amount of orders on that day was more than 30. Add to each date the person who accepted the order
# from the Employees table on that day
SELECT OrderDate, COUNT(o.OrderID) as Orders, EmployeeID, SUM(Quantity) / COUNT(od.OrderID) as Awerage
FROM orders o
         JOIN order_details od
              USING (OrderID)
GROUP BY OrderDate, EmployeeID
HAVING Awerage > 30
ORDER BY OrderDate;


# Use Group By. List the number of customers in each country, ordered by the country with the most customers first.
SELECT Country, COUNT(CustomerID) AS Number
FROM customers
GROUP BY Country
ORDER BY Number DESC;

# Use Group By List the number of customers in each country
SELECT Country, COUNT(CustomerID) AS Number
FROM customers
GROUP BY Country;