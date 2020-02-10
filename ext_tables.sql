#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
    textpic_ratio int(11) unsigned DEFAULT '0',
    visibility varchar(100) DEFAULT '' NOT NULL,
    facebook varchar(1024) DEFAULT '' NOT NULL,
    googlemaps_url varchar(1024) DEFAULT '' NOT NULL,
);
