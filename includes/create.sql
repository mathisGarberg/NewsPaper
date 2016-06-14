
/* CREATE TABLES */

CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(32),
	password VARCHAR(128),
	name VARCHAR(30),
	surname VARCHAR(30),
	email VARCHAR(30),
	user_type INT(11)
);
			
CREATE TABLE IF NOT EXISTS articles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT,
	average_id INT,
	title VARCHAR(200),
	image VARCHAR(40),
	content TEXT(1000),
	author VARCHAR(32),
	category VARCHAR(20),
	ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS user_type (
	id INT,
	name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS category (
	category VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS ratings (
	id INT AUTO_INCREMENT PRIMARY KEY,
	article INT,
	rating INT
);

/* INSERT VALUES */

/* Insert into users table */
INSERT INTO users(username, password, name, surname, email, user_type) 
	VALUES(
	'Smash',
	'$2a$10$yHkdMopa.03bBmewcnLecuAGfzHMBdAm4Rbb0.Zg5/oCTRbdF/ZxS', /* hash for 12345 */
	'Mathis',
	'Garberg',
	'Mathis.Garberg@gmail.com',
	'1'
);

INSERT INTO users(username, password, name, surname, email, user_type) 
	VALUES(
	'Bilbo',
	'$2a$10$yHkdMopa.03bBmewcnLecuAGfzHMBdAm4Rbb0.Zg5/oCTRbdF/ZxS', /* hash for 12345 */
	'Fred',
	'Henriksen',
	'Fred.Henriksen@gmail.com',
	'2'
);

INSERT INTO users(username, password, name, surname, email, user_type) 
	VALUES(
	'Vegeta',
	'$2a$10$yHkdMopa.03bBmewcnLecuAGfzHMBdAm4Rbb0.Zg5/oCTRbdF/ZxS', /* hash for 12345 */
	'Jonas',
	'Garberg',
	'Jonas.Garberg@gmail.com',
	'2'
);

INSERT INTO users(username, password, name, surname, email, user_type) 
	VALUES(
	'Stig',
	'$2a$10$yHkdMopa.03bBmewcnLecuAGfzHMBdAm4Rbb0.Zg5/oCTRbdF/ZxS', /* hash for 12345 */
	'Stig',
	'Garberg',
	'Stig.Garberg@gmail.com',
	'2'
);

INSERT INTO users(username, password, name, surname, email, user_type) 
	VALUES(
	'Robert',
	'$2a$10$yHkdMopa.03bBmewcnLecuAGfzHMBdAm4Rbb0.Zg5/oCTRbdF/ZxS', /* hash for 12345 */
	'Robert',
	'Huth',
	'Robert.Huth@gmail.com',
	'2'
);
	
/* Insert into articles table */

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'1',
	'US moves to sell gene-edited mushrooms fuel doubts over British ban on GM imports',
	'Anti-GM protesters.jpg',
	'American regulators have allowed the cultivation and sale of two crops 
	modified with the gene-editing technique known as Crispr. The crops "a white 
	button mushroom and a form of corn" are the first Crispr plants to be 
	permitted for commercial use in the US.',
	'Stig Garberg',
	'Science'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category)
	VALUES(
	'1',
	'2',
	'Villa Relegated',
	'Manchester-United-v-Aston-Villa.jpg',
	'The bleak fate which with Aston Villa have been flirting for the past five years 
	finally became a reality yesterday (SAT) when they were relegated with four matches 
	of their abject season remaining. Marcus Rashford’s seventh goal in 12 games for 
	Manchester United was enough to inflict a ninth successive defeat on Villa. 
	Talk about going down without a fight.',
	'Mathis Garberg',
	'sports'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'1',
	'3',
	'Louis van Gaal prefers Wembley hero Anthony Martial as a wide man',
	'Wembley_hero_Anthony_Martial.jpg',
	'Anthony Martial gave one of his most impressive performances to date in his 
	first club game at Wembley and provided the winning goal that took Manchester 
	United past Everton to the FA Cup final, but Louis van Gaal insists the French 
	player is a winger rather than a striker who will end up with goalscoring records',
	'Mathis Garberg',
	'sports'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'1',
	'4',
	'Magnus Carlsen and Sergey Karjakin unlikely to meet before world title',
	'White mates in three moves.jpg',
	'The battle lines are drawn. Magnus Carlsen and Sergey Karjakin, seven 
	months before their world title match, have announced their tournament 
	schedules, with only a minuscule chance of a direct clash.',
	'Mathis Garberg',
	'sports'
);


INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'5',
	'Cancer charity hits back at critics of ‘Fight Club’ sponsored bouts',
	'Boxers at a UWCB event.jpg',
	'A leading cancer charity has defended its use of amateur boxing bouts to 
	raise funds, despite calls for the unlicensed sponsored contests to be banned. 
	Cancer Research UK has a corporate partnership with a company called Ultra 
	White Collar Boxing (UWCB), which offers what has been dubbed a "Fight Club 
	experience", named after the 1999 cult film.',
	'Stig Garberg',
	'Science'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'6',
	'Struggle to sleep in a strange bed? Scientists have uncovered why',
	'Hard to sleep.jpg',
	'Just as birds and dolphins stay alert for predators whilst asleep, 
	it seems that half of the human brain may remain similarly watchful 
	in new surroundings.',
	'Stig Garberg',
	'Science'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'7',
	'How Facebook plans to take over the world',
	'Mark Zuckerberg.jpg',
	'Whichever way you look at it, Facebook is booming; publishers, businesses and brands are clinging on for the ride.',
	'Stig Garberg',
	'Technology'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'8',
	'Facebook is going to start showing you pieces people actually read',
	'Facebook.jpg',
	'Another algorithm change has been announced by the social network, 
	focused on enhancing reading time. Facebook is changing its algorithm 
	yet again, and this time it wants to show you more things that you’ll 
	actually spend time reading or watching.',
	'Stig Garberg',
	'Technology'
);


INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'9',
	'Apple transparency report: over 1,000 government requests for user data',
	'Apples transparency report.jpg',
	'US authorities asked for user data from Apple accounts 1,015 times 
	during the second half of 2015, according to figures the iPhone maker 
	released Tuesday. The requests pertain to information on services such 
	as iMessages, emails, photos and device backups.',
	'Stig Garberg',
	'Technology'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'4',
	'10',
	'Google\'s parent Alphabet misses profit expectations as moonshot spend soars',
	'Google Alphabet.jpg',
	'Google’s parent company Alphabet saw its revenue grow 17% during the 
	first three months of this year, the company said on Thursday, but 
	spent more money on its experimental moonshot projects, engineers, 
	data centers and YouTube shows, causing it to miss investors’ 
	profit expectations.',
	'Stig Garberg',
	'Technology'
);

INSERT INTO articles(user_id, average_id, title, image, content, author, category) 
	VALUES(
	'1',
	'11',
	'Ratchet & Clank review: silly fun with a few surprises',
	'Ratchet & Clank.jpg',
	'Released to coincide with the forthcoming movie, Ratchet & Clank could 
	have been a cash grab – a cynical HD reskin of Insomniac Games’s classic 
	action adventure. It could have been churned out fast to capitalise on 
	all the goodwill and publicity surrounding the film. But it isn’t and 
	it wasn’t. It’s great.',
	'Mathis Garberg',
	'Technology'
);


/* Insert into user_type table */
INSERT INTO user_type(id, name) 
	VALUES(
	1,
	'Admin'
);

INSERT INTO user_type(id, name) 
	VALUES(
	2,
	'Member'
);

/* Insert into category table */
INSERT INTO category (category)
	VALUES(
	'Sports'
);

INSERT INTO category (category)
	VALUES(
	'Science'
);
INSERT INTO category (category)
	VALUES(
	'Technology'
);

INSERT INTO category (category)
	VALUES(
	'Music'
);