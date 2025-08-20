# Hotel Reservation API

RESTful API for managing hotel room reservations.

<img width="1253" height="845" alt="Image" src="https://github.com/user-attachments/assets/aacafd26-4900-4333-a59f-32d5e24384e4" />

<img width="1503" height="784" alt="Image" src="https://github.com/user-attachments/assets/097cf41f-1904-4247-a6a3-57615cf837e6" />

## Technologies

-   Laravel 12.20.0
-   PHP 8.2.12

## Project Description

RESTful API for comprehensive hotel reservation management. The system allows users to full CRUD operations.

Information:

**Reservation Model:**
-   id: Unique identifier
-   guestName: Text (required)
-   guestEmail: Text (required)
-   comments: Text (optional)
-   checkInDate: DateTime (required)
-   checkOutDate: DateTime (optional)
-   roomType: Text (required) - Values: "single", "double", "suite", "family"

**Business Rules:**
1. Check-in date must be at least 1 hour after current date
2. Maximum stay duration is 30 days
3. Room type must be one of the allowed values

**Endpoints:**
- Create a new Reservation: Receives a payload with the required reservation details and returns the ID of the newly created reservation.
- List Reservations: Returns all existing reservations (no filters or sorting will be applied at this stage; this functionality will be added later).
- Get a Reservation: Retrieves reservation details using filters (ID or guest name).
- Update a Reservation: Modifies an existing reservation using the provided payload and returns the updated reservation object.
- Delete a Reservation: Removes a reservation by ID and returns a boolean indicating result.

**Additional:**
Reservation Creation Events: When a new reservation is created, the system automatically triggers these actions:
- Generates the reservation invoice
- Sends a confirmation email to the guest

Request Validation:  
- Uses Laravel's form request validation to ensure that incoming data is well-structured and complies with defined rules before processing.

Exception Handling:  
- Centralized exception handling is implemented using Laravel's `Handler` class to manage errors gracefully and return appropriate responses.

## API Endpoints
- `/reservations/new` - Create a new reservation.
- `/reservations/all` - List all reservations.
- `/reservations/find` - Find reservations by id and/or guest name.
- `/reservations/update` - Update a specific reservation..
- `reservations/delete/{id}` - Delete a specific reservation.

## Setup / Installation

Follow these steps to run the Hotel Reservation API locally:

### 1. Clone the repository
```bash
git clone <repository-url>
cd <repository-folder>
```

### 2. Setup environment
- Copy the example `.env` file:
```bash
cp .env.example .env
```
- Configure your database connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rh-l-api
```

### 3. Create the database
Make sure MySQL is running and create the database defined in `.env`:
```sql
CREATE DATABASE rh-l-api;
```

### 4. Run migrations
```bash
php artisan migrate
```

### 5. Serve the application
```bash
php artisan serve
```
The API will be available at: `http://127.0.0.1:8000`

### 6. Run tests
```bash
php artisan test
```

## Requests & Responses examples Endpoints

### Create New Reservation:

**Endpoint:**  
 `POST /api/reservations/new`
**Request Example:**

```json
{
    "guestName": "Juan Pérez",
    "guestEmail": "juanpe@example.com",
    "comments": "Late night arrival",
    "checkInDate": "2025-07-28 14:00:00",
    "checkOutDate": "2025-07-30 12:00:00",
    "roomType": "single"
}
```

**Successful Response:**

```json
{
    "success": true,
    "message": "Reservation created successfully",
    "data": "227256d2-77c4-4a01-b85c-9c5e7b0f5102"
}
```

### List All Reservations:

**Endpoint:**  
 `GET /api/reservations/all`
**Successful Response Example:**

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        "227256d2-77c4-4a01-b85c-9c5e7b0f5102": {
            "id": "227256d2-77c4-4a01-b85c-9c5e7b0f5102",
            "guestName": "Juan Pérez",
            "guestEmail": "juanpe@example.com",
            "comments": "Late night arrival",
            "checkInDate": "2025-07-28 14:00:00",
            "checkOutDate": "2025-07-30 12:00:00",
            "roomType": "single",
            "status": "confirmed"
        },
        "7755b28b-e0cb-41d1-8408-19de2a3b6fc4": {
            "id": "7755b28b-e0cb-41d1-8408-19de2a3b6fc4",
            "guestName": "Marta López",
            "guestEmail": "juanpe@example.com",
            "comments": "Early check-in requested",
            "checkInDate": "2025-08-01 10:00:00",
            "checkOutDate": "2025-08-05 12:00:00",
            "roomType": "double",
            "status": "pending"
        }
    }
}
```

### Find Reservations

**Endpoint:**  
`GET /api/reservations/find`
**Request Example:**

-   Search by ID:
    `/api/reservations/find?id=227256d2-77c4-4a01-b85c-9c5e7b0f5102`
-   Search by guest name:
    `/api/reservations/find?guestName=Juan%20Pérez`
    **Successful Response Example:**

```json
{
    "success": true,
    "message": "Reservation found successfully",
    "data": [
        {
            "id": "227256d2-77c4-4a01-b85c-9c5e7b0f5102",
            "guestName": "Juan Pérez",
            "guestEmail": "juanpe@example.com",
            "comments": "Late night arrival",
            "checkInDate": "2025-07-28 14:00:00",
            "checkOutDate": "",
            "roomType": "single"
        }
    ]
}
```

**Error Response Example (Reservation not found):**

```json
{
    "success": false,
    "message": "Reservation not found",
    "data": null
}
```

### Update Reservation

**Endpoint:**  
`PUT /api/reservations/update`
**Request Example:**

```json
{
    "id": "227256d2-77c4-4a01-b85c-9c5e7b0f5102",
    "guestName": "Juan Updated",
    "guestEmail": "juanpe@example.com",
    "comments": "Late night arrival",
    "checkInDate": "2025-08-15 10:22:51",
    "checkOutDate": "",
    "roomType": "family" // single/double/family/suite/
}
```

**Successful Response Example:**

```json
{
    "success": true,
    "message": "Reservation found successfully",
    "data": [
        {
            "id": "227256d2-77c4-4a01-b85c-9c5e7b0f5102",
            "guestName": "Juan Updated",
            "guestEmail": "juanpe@example.com",
            "comments": "Late night arrival",
            "checkInDate": "2025-07-28 12:10:23",
            "checkOutDate": "2025-08-27 12:10:23",
            "roomType": "family"
        }
    ]
}
```

**Error Response Example (Reservation not found):**

```json
{
    "success": false,
    "message": "Internal server error: Reservation not found",
    "data": null
}
```

### Delete Reservation

**Endpoint:**  
`DELETE /api/reservations/delete/{id}`
**Request Example:**
`/api/reservations/delete/id=227256d2-77c4-4a01-b85c-9c5e7b0f5102`
**Successful Response Example:**

```json
{
    "success": true,
    "message": "Reservation deleted successfully",
    "data": null
}
```

**Error Response Example (Reservation not found):**

```json
{
    "success": false,
    "message": "Reservation not found",
    "data": null
}
```

### Clear Reservation Storage:

**Description:**
This administrative endpoint completely purges all reservation data from the application's storage system. It performs a hard reset of the reservation database/cache, permanently deleting all reservation records.
**Endpoint:**
`GET /api/reservations/clear-storage`
**Successful Response Example:**

```json
{
    "success": true,
    "message": "Reservation storage cleared"
}
```

## Testing

### Test Classes Structure

```text
tests/Feature/Reservation/
├── ReservationCreateRouteTest.php      # Tests for creation endpoint
├── ReservationDeleteRouteTest.php      # Tests for deletion endpoint
├── ReservationFindRouteTest.php        # Tests for find operations
├── ReservationUpdateRouteTest.php      # Tests for update endpoint
└── ReservationListRouteTest.php        # Tests for listing all reservations
```

### Test Classes Overview

#### 1. ReservationCreateRouteTest
```bash
php artisan test --filter=ReservationCreateRouteTest
```
| Test Case                                | 
|------------------------------------------|
| `it_creates_a_reservation()`             | 
| `it_fails_to_create_with_invalid_data()` | 

#### 2. ReservationDeleteRouteTest  

* DELETE `/reservations/delete/{id}`

```bash
php artisan test --filter=ReservationDeleteRouteTest
```
| Test Case                                       |                                             
|-------------------------------------------------|
| `it_deletes_a_reservation()`                    |
| `it_fails_to_delete_non_existing_reservation()` |
| `it_fails_with_invalid_id()`                    |

#### 3. ReservationFindRouteTest

* GET `/reservations/find`

```bash
php artisan test --filter=ReservationFindRouteTest
```
| Test Case                                            |
|------------------------------------------------------|
| `it_finds_reservations_by_id()`                      |
| `it_finds_reservations_by_guestName()`               |
| `it_finds_reservations_by_id_and_guestName()`        |
| `it_fails_when_reservation_not_found_by_fake_id()`   |
| `it_fails_when_reservation_not_found_by_fake_name()` |

#### 4. ReservationUpdateRouteTest

* PUT `/reservations/update`

```bash
php artisan test --filter=ReservationUpdateRouteTest
```
| Test Case                                |
|------------------------------------------|
| `it_updates_the_created_reservation()`   |
| `it_fails_to_update_with_invalid_data()` |


#### 5. ReservationListRouteTest

* GET `/reservations/all`

```bash
php artisan test --filter=ReservationListRouteTest
```
| Test Case                                              | 
|--------------------------------------------------------|
| `it_returns_multiple_reservations()`                   | 
| `it_returns_single_reservation_when_only_one_exists()` | 
| `it_returns_empty_list_when_no_reservations_exist()`   | 
| `it_returns_reservations_with_expected_fields()`       | 

### Running Tests

**Run all reservation tests:**
```bash
php artisan test tests/Feature/ReservationRoutesTest.php
```

---

## Postman Collection

You can test the API endpoints using the following Postman collection URLs with the local `{{baseURL}}` environment variable:

1. `{{baseURL}}/api/reservations/new` – Create a new reservation (POST)
2. `{{baseURL}}/api/reservations/all` – List all reservations (GET)
3. `{{baseURL}}/api/reservations/find` – Search/filter reservations (GET, use query params like ?user_id=1)
4. `{{baseURL}}/api/reservations/update` – Update a reservation (PUT, include reservation_id in body)
5. `{{baseURL}}/api/reservations/delete/{id}` – Delete a reservation by ID (DELETE, replace {id})
6. `{{baseURL}}/api/reservations/clear-storage` – Clear all reservation data 

---
