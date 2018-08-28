
SET SQL_SAFE_UPDATES = 0;
UPDATE wp_options SET option_value = replace(option_value, 'http://loyalcoin.razerbite.com', 'http://lylv2.loyalcoin.io') WHERE option_name = 'home' OR option_name = 'siteurl';

UPDATE wp_posts SET guid = replace(guid, 'http://loyalcoin.razerbite.com','http://lylv2.loyalcoin.io');

UPDATE wp_posts SET post_content = replace(post_content, 'http://loyalcoin.razerbite.com', 'http://lylv2.loyalcoin.io');

UPDATE wp_postmeta SET meta_value = replace(meta_value,'http://loyalcoin.razerbite.com','http://lylv2.loyalcoin.io');
SET SQL_SAFE_UPDATES = 1;