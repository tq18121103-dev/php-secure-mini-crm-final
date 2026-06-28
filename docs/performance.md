# Performance Analysis

## Lead List

### Query

```sql
SELECT *
FROM leads
ORDER BY id DESC;
```

### EXPLAIN

- Access type: index
- Index used: PRIMARY
- Extra: Backward index scan

### Result

The query uses the PRIMARY KEY index to retrieve data in descending order efficiently.

---

## Order List

### Query

```sql
SELECT orders.*, leads.full_name AS lead_name
FROM orders
LEFT JOIN leads
ON orders.lead_id = leads.id
WHERE orders.order_code LIKE '%OD%'
ORDER BY orders.id DESC;
```

### EXPLAIN

Orders table

- type: index
- key: PRIMARY
- Extra: Using where; Backward index scan

Leads table

- type: eq_ref
- key: PRIMARY

### Result

The query joins the `orders` and `leads` tables using the PRIMARY KEY. MySQL performs an efficient `eq_ref` join and uses the primary index for sorting.