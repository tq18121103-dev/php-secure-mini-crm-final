USE secure_crm;
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE orders;
TRUNCATE TABLE leads;
TRUNCATE TABLE users;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO users(username,password,role)
VALUES
('admin', 123456, 'admin'),
('staff1', 123456, 'staff');

INSERT INTO leads
(lead_code,full_name,email,phone,source,status)
VALUES
('LD001','Nguyen Van A','a@gmail.com','0901111111','Facebook','new'),
('LD002','Tran Thi B','b@gmail.com','0901111112','Website','contacted'),
('LD003','Le Van C','c@gmail.com','0901111113','Referral','qualified'),
('LD004','Pham Thi D','d@gmail.com','0901111114','Facebook','customer'),
('LD005','Hoang Van E','e@gmail.com','0901111115','Google','lost'),
('LD006','User 6','u6@gmail.com','0901111116','Website','new'),
('LD007','User 7','u7@gmail.com','0901111117','Website','new'),
('LD008','User 8','u8@gmail.com','0901111118','Facebook','contacted'),
('LD009','User 9','u9@gmail.com','0901111119','Facebook','qualified'),
('LD010','User 10','u10@gmail.com','0901111120','Google','customer');

INSERT INTO orders
(order_code,lead_id,amount,order_status)
VALUES
('OD001',1,1000000,'paid'),
('OD002',2,2000000,'pending'),
('OD003',3,3500000,'paid'),
('OD004',4,800000,'cancelled'),
('OD005',5,1500000,'pending'),
('OD006',6,900000,'paid'),
('OD007',7,760000,'pending'),
('OD008',8,2200000,'paid'),
('OD009',9,650000,'cancelled'),
('OD010',10,990000,'paid');