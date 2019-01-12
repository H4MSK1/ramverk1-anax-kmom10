--
-- Create the database with a testuser
--
CREATE DATABASE IF NOT EXISTS ramverk1;
GRANT ALL ON ramverk1.* TO user@localhost IDENTIFIED BY "pass";
USE ramverk1;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;
