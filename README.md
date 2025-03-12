# Bank App API Documentation

This document provides details about the Bank App API endpoints, their parameters, and expected responses.

## Table of Contents
- [Authentication](#authentication)
  - [Register](#register)
  - [Login](#login)
  - [Logout](#logout)
- [Wallet Management](#wallet-management)
  - [Create Wallet](#create-wallet)
  - [Update Balance](#update-balance)
  - [Delete Wallet](#delete-wallet)
- [Transactions](#transactions)
  - [Create Transaction](#create-transaction)
  - [Update Transaction Status](#update-transaction-status)
  - [Delete Transaction](#delete-transaction)

## Authentication

### Register

Creates a new user account and automatically creates a wallet for the user.

**Endpoint:** `POST /register`

**Request Parameters:**
```json
{
  "firstname": "string",
  "lastname": "string",
  "email": "string",
  "password": "string",
  "img": "string"
}
```

**Response:**
```json
{
  "createWallet": {
    "number": "string",
    "user_id": "integer",
    "balance": 0,
    "id": "integer"
  },
  "user": {
    "user": {
      "id": "integer",
      "firstname": "string",
      "lastname": "string",
      "email": "string",
      "img": "string"
    },
    "token": "string"
  }
}
```

### Login

Authenticates a user and returns a token.

**Endpoint:** `POST /login`

**Request Parameters:**
```json
{
  "email": "string",
  "password": "string"
}
```

**Response:**
```json
{
  "user": {
    "id": "integer",
    "firstname": "string",
    "lastname": "string",
    "email": "string",
    "img": "string"
  },
  "token": "string"
}
```

### Logout

Logs out the current user and invalidates their token.

**Endpoint:** `POST /logout`

**Headers:**
- Authorization: Bearer {token}

**Response:**
```json
{
  "message": "is logout"
}
```

## Wallet Management

### Create Wallet

Creates a new wallet for a user.

**Endpoint:** `POST /wallet`

**Headers:**
- Authorization: Bearer {token}

**Request Parameters:**
```json
{
  "user_id": "integer",
  "balance": "number"
}
```

**Response:**
```json
{
  "number": "string",
  "user_id": "integer",
  "balance": "number",
  "id": "integer"
}
```

### Update Balance

Updates the balance of a wallet.

**Endpoint:** `PUT /wallet/balance`

**Headers:**
- Authorization: Bearer {token}

**Request Parameters:**
```json
{
  "id": "integer",
  "balance": "number"
}
```

**Response:**
```json
{
  "message": "updated succ"
}
```

### Delete Wallet

Deletes a wallet.

**Endpoint:** `DELETE /wallet`

**Headers:**
- Authorization: Bearer {token}

**Request Parameters:**
```json
{
  "delete_id": "integer"
}
```

**Response:**
```json
{
  "message": "deleted"
}
```

## Transactions

### Create Transaction

Creates a new transaction between two wallets.

**Endpoint:** `POST /transaction`

**Headers:**
- Authorization: Bearer {token}

**Request Parameters:**
```json
{
  "amount": "number",
  "description": "string",
  "receiver": "string" // email of the receiver
}
```

**Response:**
```json
{
  "transaction": {
    "id": "integer",
    "amount": "number",
    "description": "string",
    "date": "timestamp",
    "receiver_id": "integer",
    "sender_id": "integer",
    "status": "active"
  }
}
```

**Error Responses:**
- Insufficient funds:
```json
{
  "message": "Insufficient funds"
}
```
- Receiver not found:
```json
{
  "message": "not found"
}
```
- Wallet not found:
```json
{
  "message": "wallet not found"
}
```

### Update Transaction Status

Updates the status of a transaction.

**Endpoint:** `PUT /transaction/status`

**Headers:**
- Authorization: Bearer {token}

**Request Parameters:**
```json
{
  "id": "integer",
  "status": "string"
}
```

**Response:**
```json
{
  "message": "status updated"
}
```

### Delete Transaction

Deletes a transaction.

**Endpoint:** `DELETE /transaction`

**Headers:**
- Authorization: Bearer {token}

**Request Parameters:**
```json
{
  "delete_id": "integer"
}
```

**Response:**
```json
{
  "message": "deleted"
}
```

## Error Handling

All endpoints perform validation and may return error messages in the following format:

```json
{
  "message": "error description"
}
```

## Authentication Notes

- All API endpoints except for `/register` and `/login` require authentication.
- Authentication is handled via Bearer tokens that are returned after logging in.
- Include the token in the Authorization header for all authenticated requests.

## Transaction Security

- Transactions use database transactions to ensure data integrity.
- If any part of the transaction fails, all changes are rolled back to prevent inconsistencies.
