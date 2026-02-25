-- Fix: Bank Transfer checkout SQL error (payment_method enum only allowed 'stripe','cod')
-- Run this manually if migration does not work: php artisan migrate
-- Or execute in phpMyAdmin / MySQL client:

ALTER TABLE orders MODIFY COLUMN payment_method VARCHAR(50) NOT NULL DEFAULT 'cod';
