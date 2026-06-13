# Mobile App OTP & Email Verification Integration Documentation

This document describes the API endpoints and payloads for integrating phone/email OTP generation, verification, and authenticated user account verification in the mobile app.

---

## 1. Send OTP (Phone / Email)

Sends an OTP to the user's phone (via 2factor SMS) or email address, and caches it statelessly for server-side verification.

- **Endpoint:** `POST /send-otp` (Direct web route; CSRF verification is bypassed)
- **Headers:**
  ```http
  Accept: application/json
  Content-Type: application/x-www-form-urlencoded
  X-Requested-With: XMLHttpRequest
  ```

### Option A: Phone Number Delivery (form-encoded)
- **Request Body:**
  ```
  phone=9876543210&country_code=91&delivery_method=phone
  ```
  | Field | Type | Required | Description |
  |-------|------|----------|-------------|
  | `phone` | string | Yes | The phone number digits without dial code or symbols |
  | `country_code` | string | Yes | Country code without leading `+` (e.g. `91` for India) |
  | `delivery_method` | string | Yes | Must be explicitly set to `phone` |

### Option B: Email Delivery (form-encoded)
- **Request Body:**
  ```
  email=user@example.com&delivery_method=email
  ```
  | Field | Type | Required | Description |
  |-------|------|----------|-------------|
  | `email` | string | Yes | Target email address |
  | `delivery_method` | string | Yes | Must be explicitly set to `email` |

### Success Response (`200 OK`)
```json
{
  "success": true,
  "message": "OTP sent successfully",
  "otp": "482910"
}
```
> **Security Note:** While the `"otp"` field is returned for legacy client compatibility, the mobile app should submit the user-entered OTP to the `/verify-otp` endpoint for validation rather than verifying it client-side.

### Failure Responses
- **Phone/Email Already Exists:**
  ```json
  {
    "success": false,
    "message": "Phone number already exists"
  }
  ```
- **Failed to Send:**
  ```json
  {
    "success": false,
    "message": "Failed to send OTP"
  }
  ```

---

## 2. Verify OTP (Phone / Email)

Validates a generated phone or email OTP state-lessly on the server.

- **Endpoint:** `POST /verify-otp` (Direct web route; CSRF verification is bypassed)
- **Headers:**
  ```http
  Accept: application/json
  Content-Type: application/x-www-form-urlencoded
  X-Requested-With: XMLHttpRequest
  ```

### Option A: Verify Phone OTP (form-encoded)
- **Request Body:**
  ```
  phone=9876543210&country_code=91&otp=482910
  ```

### Option B: Verify Email OTP (form-encoded)
- **Request Body:**
  ```
  email=user@example.com&otp=482910
  ```

### Success Response (`200 OK`)
```json
{
  "success": true,
  "message": "OTP verified successfully"
}
```

### Failure Response (`200 OK`)
```json
{
  "success": false,
  "message": "Invalid or expired OTP"
}
```

---

## 3. Email Verification Code (Authenticated User)

Verifies the user account after logging in.

- **Endpoint:** `POST /api/verify/code`
- **Headers:**
  ```http
  Accept: application/json
  Content-Type: application/json
  Authorization: Bearer <user_access_token>
  ```
- **Request Body:**
  ```json
  {
    "verification_code": "123456"
  }
  ```

### Success Response (`200 OK`)
```json
{
  "result": true,
  "message": "Account verified successfully"
}
```

### Failure Response (`200 OK` or `400 Bad Request`)
```json
{
  "result": false,
  "message": "Verification code does not match!!"
}
```

---

## 4. Resend Verification Code (Authenticated User)

Resends the email verification code.

- **Endpoint:** `GET /api/resend-verify/code`
- **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <user_access_token>
  ```

### Success Response (`200 OK`)
```json
{
  "result": true,
  "message": "Verification code resent"
}
```
