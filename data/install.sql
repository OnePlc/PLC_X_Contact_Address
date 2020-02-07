--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-address', 'contact-single', 'Address', 'Delivery & Billing', 'fas fa-home', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Address', 'contact_address', 'contact-address', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- create address table
--
CREATE TABLE `contact_address` (
  `Address_ID` int(11) NOT NULL,
  `contact_idfs` int(11) NOT NULL,
  `street` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_extra` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appartment` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `contact_address`
  ADD PRIMARY KEY (`Address_ID`);

ALTER TABLE `contact_address`
  MODIFY `Address_ID` int(11) NOT NULL AUTO_INCREMENT;


--
-- add address form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('contactaddress-single', 'Contact Address', 'OnePlace\\Contact\\Address\\Model\\Address', 'OnePlace\\Contact\\Address\\Model\\AddressTable');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Street', 'street', 'address-base', 'contactaddress-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'select', 'Contact', 'contact_idfs', 'address-base', 'contactaddress-single', 'col-md-3', '', '/contact/api/list/0', '0', '1', '0', 'contact-single', 'OnePlace\\Contact\\Model\\ContactTable', 'add-OnePlace\\Contact\\Controller\\ContactController');
