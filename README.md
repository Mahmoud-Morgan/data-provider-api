# User API with Strategy Pattern and Filters
### Overview
This project implements a user data retrieval API using the Strategy Pattern to handle multiple data providers. It allows filtering the user data based on several criteria such as provider, status code, amount range, and currency. The main endpoint for this API is /api/v1/users.

#### API Endpoint /api/v1/users
Functionality
List all users: Combines transactions from all available providers (DataProviderX and DataProviderY).
- Filter by provider: Returns users from a specific provider. Example: /api/v1/users?provider=DataProviderX.
- Filter by status code: Returns users with a specific status code. Example: /api/v1/users?statusCode=authorised.
- Filter by amount range: Returns users with an amount within a specified range. Example: /api/v1/users?balanceMin=10&balanceMax=100.
- Filter by currency: Returns users with a specific currency. Example: /api/v1/users?currency=USD.
- Combine filters: Allows combining multiple filters together.

### Implementation
- Strategy Pattern for Data Providers

The Strategy Pattern is used to handle different data providers (DataProviderX and DataProviderY). This allows the application to be easily extended to support new data providers in the future.

### Structure
- Context Class: DataProviderContext

This class is responsible for interacting with the data provider strategies.
- Strategy Interface: DataProviderInterface

Defines the method that all data provider strategies must implement.
- Concrete Strategies: DataProviderX, DataProviderY

Each of these classes implements the DataProviderInterface and provides the specific logic to retrieve data from the respective data provider.

### Filters
The API supports various filters that can be applied individually or in combination to narrow down the results.

#### Available Filters
1.Provider Filter: Filters results based on the specified provider.

2.Status Code Filter: Filters results based on the status code (authorised, decline, refunded).

3.Amount Range Filter: Filters results based on the specified minimum and maximum amount.

4.Currency Filter: Filters results based on the specified currency.
