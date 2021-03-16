--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-address', 'contact-single', 'Address', 'Delivery & Billing', 'fas fa-home', '', '0', '', '');

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
  `street_extra` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `appartment` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_idfs` int(11) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(NULL, 'text', 'Apt', 'appartment', 'address-base', 'contactaddress-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Zip', 'zip', 'address-base', 'contactaddress-single', 'col-md-1', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'City', 'city', 'address-base', 'contactaddress-single', 'col-md-4', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Contact', 'contact_idfs', 'address-base', 'contactaddress-single', 'col-md-3', '', '/', '0', '1', '0', '', '', ''),
(NULL, 'select', 'Country', 'country_idfs', 'address-base', 'contactaddress-single', 'col-md-3', '', '/tag/api/list/address-single/country', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\CountryController');

--
-- add new tag country
--
INSERT IGNORE INTO `core_tag` (`Tag_ID`, `tag_key`, `tag_label`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(NULL, 'country', 'Country', '1', '0000-00-00 00:00:00', '1', '0000-00-00 00:00:00');

--
-- permission add country
--
INSERT IGNORE INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`, `needs_globaladmin`) VALUES
('add', 'OnePlace\\Tag\\Controller\\CountryController', 'Add Country', '', '', 0, 0);

--
-- quicksearch fix
--
INSERT INTO `settings` (`settings_key`, `settings_value`) VALUES ('quicksearch-contactaddress-customlabel', 'street');
