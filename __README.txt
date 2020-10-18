







+ Manage paid plans from the administration
+ Enable/Disable Plans from administration
+ Add Social media login (Facebook, Twitter, Google) ------ Still needs testing for facebook
+ Enable/Disable site registration from administration
+ Move script configirations to administration
+ Add SMTP email system
+ Edit user plan from administration
+ Add Embed Survey button and generate the iFrame
+ Send survey via email list
+ Change the "Send Survey" buttom from top to bottom

+ Fix bugs





+ Updates

remove old and add plans table

ALTER TABLE `puerto_users` ADD `social_id` VARCHAR(200) NULL AFTER `city`, ADD `social_name` VARCHAR(200) NULL AFTER `social_id`;



INSERT INTO `puerto_configs` (`id`, `variable`, `value`) VALUES
(8, 'site_forget', '1'),
(10, 'site_noreply', 'donotreply@puertokhalid.com'),
(12, 'login_facebook', '1'),
(13, 'login_twitter', '1'),
(14, 'login_google', '1'),
(15, 'login_fbAppId', ''),
(16, 'login_fbAppSecret', ''),
(17, 'login_fbAppVersion', ''),
(18, 'login_twConKey', ''),
(19, 'login_twConSecret', ''),
(20, 'login_ggClientId', ''),
(21, 'login_ggClientSecret', ''),
(22, 'site_paypal_id', ''),
(23, 'site_paypal_live', '0'),
(24, 'site_currency_symbol', '$'),
(25, 'site_currency_name', 'USD'),
(26, 'site_smtp', '1'),
(27, 'site_smtp_host', 'smtp1.example.com'),
(28, 'site_smtp_username', 'user@example.com'),
(29, 'site_smtp_password', ''),
(30, 'site_smtp_encryption', 'tls'),
(31, 'site_smtp_port', '587'),
(32, 'site_smtp_auth', '1'),
(33, 'site_country', 'US');
