## Mobile API Overview

- **Auth**: All endpoints below require `Authorization: Bearer {token}` header, except `register`, `login`, and password reset endpoints.
- **Base URL**: `/api`

### Profile

- **GET** `/api/profile`
  - **Description**: Get authenticated user's profile, therapist profile (if applicable), wallet summary, and basic stats.
  - **Response**:
    - `user`: basic user info
    - `profile`: client profile fields
    - `therapist_profile`: therapist-specific profile (if user is therapist)
    - `wallet`: balance, currency
    - `stats`: `appointments_count`, `upcoming_appointments_count`

- **PUT/PATCH** `/api/profile`
  - **Body (JSON)**: any subset of:
    - `name`, `phone`, `avatar`
    - `profile.first_name`, `profile.last_name`, `profile.date_of_birth`, `profile.gender`, `profile.bio`, address fields

### Wallet

- **GET** `/api/wallet`
  - **Description**: Get wallet balance and last 10 transactions.

- **GET** `/api/wallet/transactions`
  - **Query params (optional)**:
    - `type`: `credit` or `debit`
    - `from`, `to`: `YYYY-MM-DD`
    - `per_page`: default `15`

- **POST** `/api/wallet/topup-confirm`
  - **Description**: Confirm a successful wallet top-up after payment gateway success.
  - **Body (JSON)**:
    - `amount` (number, required)
    - `payment_method` (string, e.g. `"razorpay"`)
    - `transaction_id` (string, gateway transaction/order id)
    - `description` (optional)

### Assessments

- **GET** `/api/assessments`
  - **Description**: List active assessments.

- **GET** `/api/assessments/{id}`
  - **Description**: Get a single assessment with questions.

- **POST** `/api/assessments/{id}/submit`
  - **Description**: Submit answers for an assessment.
  - **Body (JSON)**:
    - `answers`: object keyed by question id:
      - Example:
        - `{ "answers": { "1": 3, "2": 5, "3": "Sometimes" } }`

- **GET** `/api/assessments/responses`
  - **Description**: List assessment responses/history for current user (paginated).

- **GET** `/api/assessments/responses/{id}`
  - **Description**: Get a single assessment response with answers.

