DROP DATABASE IF EXISTS blog_php;
CREATE DATABASE blog_php CHARACTER SET utf8 COLLATE utf8_general_ci;
USE blog_php;

CREATE TABLE user
(
    id         int UNSIGNED AUTO_INCREMENT                                  NOT NULL,
    pseudo     varchar(255) UNIQUE                                          NOT NULL,
    role_users ENUM ('role_user','role_admin','role_editor','role_anonyme') NOT NULL DEFAULT 'role_user',
    email      varchar(255) UNIQUE,
    pass       varchar(255)                                                 NOT NULL,
    created_at datetime                                                     NOT NULL,
    updated_at datetime                                                     NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE article
(
    id         int UNSIGNED AUTO_INCREMENT NOT NULL,
    title      varchar(255)                NOT NULL,
    chapo      text                        NOT NULL,
    content    text                        NOT NULL,
    slug       varchar(255) UNIQUE         NOT NULL,
    created_at datetime                    NOT NULL,
    updated_at datetime                    NOT NULL,
    id_user    int UNSIGNED                NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_article_user FOREIGN KEY (id_user) REFERENCES user (id)
) ENGINE = InnoDB;

CREATE TABLE comment
(
    id         int UNSIGNED AUTO_INCREMENT NOT NULL,
    content    text                        NOT NULL,
    created_at datetime                    NOT NULL,
    is_active  tinyint                     NOT NULL DEFAULT 0,
    id_user    int UNSIGNED                NOT NULL,
    id_article int UNSIGNED                NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_comment_user FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE CASCADE,
    CONSTRAINT FK_comment_article FOREIGN KEY (id_article) REFERENCES article (id) ON DELETE CASCADE
) ENGINE = InnoDB;