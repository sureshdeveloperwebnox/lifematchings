# Sun Sign & Moon Sign API Endpoints Documentation

## Base URL
```
{APP_URL}/api
```
Example: `https://lifematchings.com/api`

---

## 1. Get All Sun Signs

### Endpoint
```
GET /api/sun-signs
```

### Full URL
```
{APP_URL}/api/sun-signs
```

### Description
Returns a list of all sun signs (Rasi) ordered by name.

### Authentication
Not required (Public endpoint)

### Request Headers
```
Accept: application/json
```

### Request Parameters
None

### Response Format
```json
[
    {
        "id": 1,
        "name": "Aries"
    },
    {
        "id": 2,
        "name": "Taurus"
    },
    {
        "id": 3,
        "name": "Gemini"
    }
]
```

### Example Request (cURL)
```bash
curl -X GET "https://lifematchings.com/api/sun-signs" \
  -H "Accept: application/json"
```

### Example Request (JavaScript/Fetch)
```javascript
fetch('https://lifematchings.com/api/sun-signs', {
  method: 'GET',
  headers: {
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data));
```

### Example Response
```json
[
    {
        "id": 1,
        "name": "Mesham"
    },
    {
        "id": 2,
        "name": "Rishabam"
    },
    {
        "id": 3,
        "name": "Mithunam"
    }
]
```

---

## 2. Get All Moon Signs

### Endpoint
```
GET /api/moon-signs
```

### Full URL
```
{APP_URL}/api/moon-signs
```

### Description
Returns a list of all moon signs (Natchathiram) ordered by name.

### Authentication
Not required (Public endpoint)

### Request Headers
```
Accept: application/json
```

### Request Parameters
None

### Response Format
```json
[
    {
        "id": 1,
        "name": "Aswini"
    },
    {
        "id": 2,
        "name": "Bharani"
    },
    {
        "id": 3,
        "name": "Krittika"
    }
]
```

### Example Request (cURL)
```bash
curl -X GET "https://lifematchings.com/api/moon-signs" \
  -H "Accept: application/json"
```

### Example Request (JavaScript/Fetch)
```javascript
fetch('https://lifematchings.com/api/moon-signs', {
  method: 'GET',
  headers: {
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data));
```

### Example Response
```json
[
    {
        "id": 1,
        "name": "Aswini"
    },
    {
        "id": 2,
        "name": "Bharani"
    },
    {
        "id": 3,
        "name": "Krittika"
    }
]
```

---

## 3. Get Moon Signs by Sun Sign ID

### Endpoint
```
GET /api/moon-signs/{sun_sign_id}
```

### Full URL
```
{APP_URL}/api/moon-signs/{sun_sign_id}
```

### Description
Returns a list of moon signs (Natchathiram) that are associated with a specific sun sign (Rasi).

### Authentication
Not required (Public endpoint)

### Request Headers
```
Accept: application/json
```

### URL Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `sun_sign_id` | integer | Yes | The ID of the sun sign |

### Response Format

**Success Response (200 OK):**
```json
[
    {
        "id": 1,
        "name": "Aswini"
    },
    {
        "id": 2,
        "name": "Bharani"
    }
]
```

**Empty Response (when no moon signs mapped):**
```json
[]
```

**Error Response (404 Not Found):**
```json
{
    "result": false,
    "message": "Error fetching moon signs",
    "data": []
}
```

### Example Request (cURL)
```bash
curl -X GET "https://lifematchings.com/api/moon-signs/1" \
  -H "Accept: application/json"
```

### Example Request (JavaScript/Fetch)
```javascript
const sunSignId = 1;
fetch(`https://lifematchings.com/api/moon-signs/${sunSignId}`, {
  method: 'GET',
  headers: {
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data));
```

### Example Response
```json
[
    {
        "id": 1,
        "name": "Aswini"
    },
    {
        "id": 2,
        "name": "Bharani"
    },
    {
        "id": 3,
        "name": "Krittika"
    }
]
```

---

## Complete Usage Example

### React Native / Mobile App Example

```javascript
// Get all sun signs
const getSunSigns = async () => {
  try {
    const response = await fetch('https://lifematchings.com/api/sun-signs', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });
    const sunSigns = await response.json();
    return sunSigns;
  } catch (error) {
    console.error('Error fetching sun signs:', error);
    return [];
  }
};

// Get all moon signs
const getMoonSigns = async () => {
  try {
    const response = await fetch('https://lifematchings.com/api/moon-signs', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });
    const moonSigns = await response.json();
    return moonSigns;
  } catch (error) {
    console.error('Error fetching moon signs:', error);
    return [];
  }
};

// Get moon signs by sun sign
const getMoonSignsBySunSign = async (sunSignId) => {
  try {
    const response = await fetch(`https://lifematchings.com/api/moon-signs/${sunSignId}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });
    const moonSigns = await response.json();
    return moonSigns;
  } catch (error) {
    console.error('Error fetching moon signs:', error);
    return [];
  }
};

// Usage
const loadData = async () => {
  // Load all sun signs for dropdown
  const sunSigns = await getSunSigns();
  console.log('Sun Signs:', sunSigns);
  
  // When user selects a sun sign, load related moon signs
  const selectedSunSignId = 1;
  const moonSigns = await getMoonSignsBySunSign(selectedSunSignId);
  console.log('Moon Signs for Sun Sign ID 1:', moonSigns);
};
```

---

## Response Data Structure

### Sun Sign Object
```json
{
    "id": 1,           // Integer - Unique identifier
    "name": "Mesham"   // String - Sun sign name
}
```

### Moon Sign Object
```json
{
    "id": 1,           // Integer - Unique identifier
    "name": "Aswini"   // String - Moon sign name
}
```

---

## Error Handling

All endpoints return standard HTTP status codes:

- **200 OK** - Successful request
- **404 Not Found** - Sun sign ID not found (for moon-signs/{id} endpoint)
- **500 Internal Server Error** - Server error

---

## Notes

1. All endpoints are **public** and do not require authentication
2. All responses are in **JSON format**
3. Data is ordered by **name** alphabetically
4. The `moon-signs/{id}` endpoint returns an empty array if no moon signs are mapped to the sun sign
5. Replace `{APP_URL}` with your actual application URL (e.g., `https://lifematchings.com`)

---

## Integration Checklist

- [ ] Replace `{APP_URL}` with your actual domain
- [ ] Test all three endpoints
- [ ] Handle empty responses appropriately
- [ ] Implement error handling for network failures
- [ ] Cache responses if needed for better performance

