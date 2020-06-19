CREATE TABLE IF NOT EXISTS gb_discounts(
	DiscountID INT UNSIGNED NOT NULL AUTO_INCREMENT,
	caption VARCHAR(64) NOT NULL DEFAULT "",
	begining INT UNSIGNED NOT NULL DEFAULT 1,
	ended INT UNSIGNED NOT NULL DEFAULT 1,
	essence VARCHAR(1024) NOT NULL DEFAULT "",
	sticker VARCHAR(8) NOT NULL DEFAULT "",
	discount TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY(DiscountID)
)ENGINE=InnoDB CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS gb_showcase(
	PageID INT UNSIGNED NOT NULL,
	articul INT UNSIGNED NOT NULL,
	language ENUM('uk','ru') NOT NULL DEFAULT 'uk',
	CategoryID INT UNSIGNED NOT NULL,
	LineupID INT UNSIGNED,
	DiscountID INT UNSIGNED,
	
	named VARCHAR(256) NOT NULL DEFAULT '',
	preview VARCHAR(256),
	mediaset VARCHAR(4096) NOT NULL DEFAULT '[]',

	price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	currency ENUM('EUR','USD','UAH') NOT NULL DEFAULT 'EUR',
	
	subtemplate VARCHAR(32) NOT NULL DEFAULT '',
	status ENUM('available','not available') NOT NULL DEFAULT 'not available',
	
	engine VARCHAR(16) NOT NULL DEFAULT '',
	horsepower VARCHAR(16) NOT NULL DEFAULT '',
	body VARCHAR(48) NOT NULL DEFAULT '',
	interior VARCHAR(48) NOT NULL DEFAULT '',

	options VARCHAR(2048) NOT NULL DEFAULT '{
		"fuel":"",
		"power":"",
		"gearbox":"",
		"drive":"",
		"consumption":"",
		"speed":"",
		"racing":"",
		"capacity":"",
		"torque":""
	}',
	equipment BLOB,
	additional BLOB,
	PRIMARY KEY(PageID),
	UNIQUE(articul, language),
	FOREIGN KEY (PageID) REFERENCES gb_pages(PageID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (CategoryID) REFERENCES gb_sitemap(PageID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (LineupID) REFERENCES gb_lineup(PageID)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	FOREIGN KEY (DiscountID) REFERENCES gb_discounts(DiscountID)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)ENGINE=InnoDB CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS gb_filters(
	FilterID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	value VARCHAR(48) NOT NULL,
	caption VARCHAR(48) NOT NULL,
	UNIQUE(value)
)ENGINE=InnoDB CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS item_vs_filters(
	FilterID INT UNSIGNED NOT NULL,
	PageID INT UNSIGNED NOT NULL,
	PRIMARY KEY(FilterID,PageID),
	FOREIGN KEY (FilterID) REFERENCES gb_filters(FilterID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (PageID) REFERENCES gb_pages(PageID)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)ENGINE=InnoDB CHARACTER SET utf8;