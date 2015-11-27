USE `Conference_Scheduler`;

DROP TABLE IF EXISTS `speakers_invitations`;
DROP TABLE IF EXISTS `lectures_participants`;
DROP TABLE IF EXISTS `conferences_participants`;
DROP TABLE IF EXISTS `conferences_administrators`;
DROP TABLE IF EXISTS `lectures`;
DROP TABLE IF EXISTS `halls`;
DROP TABLE IF EXISTS `conferences`;
DROP TABLE IF EXISTS `venues`;

CREATE TABLE `speakers_invitations` (
    lecture_id INT NOT NULL,
    speaker_id INT NOT NULL,
    isRead BOOL NOT NULL DEFAULT FALSE,
    status NVARCHAR(16) NOT NULL DEFAULT 'waiting',
    FOREIGN KEY (lecture_id) REFERENCES users(id),
    FOREIGN KEY (speaker_id) REFERENCES users(id));

CREATE TABLE `venues` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name NVARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    address NVARCHAR(255) NOT NULL,
    isActive BOOLEAN NOT NULL DEFAULT TRUE);

CREATE TABLE `halls` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name NVARCHAR(255) NOT NULL UNIQUE,
    capacity INT NOT NULL,
    venue_id INT NOT NULL,
    FOREIGN KEY (venue_id) REFERENCES venues(id));

CREATE TABLE `conferences` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title NVARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    is_active BOOL NOT NULL DEFAULT TRUE,
    owner_id INT NOT NULL,
    venue_id INT NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES users(id),
    FOREIGN KEY (venue_id) REFERENCES venues(id));

CREATE TABLE `conferences_participants` (
    conference_id INT NOT NULL,
    participant_id INT NOT NULL,
    PRIMARY KEY (conference_id, participant_id),
    FOREIGN KEY (conference_id) REFERENCES conferences(id),
    FOREIGN KEY (participant_id) REFERENCES users(id));

CREATE TABLE `conferences_administrators` (
    conference_id INT NOT NULL,
    addministrator_id INT NOT NULL,
    PRIMARY KEY (conference_id, addministrator_id),
    FOREIGN KEY (conference_id) REFERENCES conferences(id),
    FOREIGN KEY (addministrator_id) REFERENCES users(id));

CREATE TABLE `lectures` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title NVARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    start_date DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    conference_id INT NOT NULL,
    hall_id INT DEFAULT NULL,
    speaker_id INT DEFAULT NULL,
    FOREIGN KEY (conference_id) REFERENCES conferences(id),
    FOREIGN KEY (hall_id) REFERENCES halls(id),
    FOREIGN KEY (speaker_id) REFERENCES users(id));

CREATE TABLE `lectures_participants` (
    lecture_id INT NOT NULL,
    participant_id INT NOT NULL,
    PRIMARY KEY (lecture_id, participant_id),
    FOREIGN KEY (lecture_id) REFERENCES users(id),
    FOREIGN KEY (participant_id) REFERENCES users(id));


SELECT * FROM venues;