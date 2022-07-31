USE blog_php;

INSERT INTO user(pseudo, role_users, email, pass, created_at, updated_at)
VALUES ('toto', 'role_admin', 'admin@admin.com', 'test', ADDDATE(NOW(), INTERVAL -4 DAY), NOW()),
       ('tata', 'role_editor', 'editor@editor.com', 'test', ADDDATE(NOW(), INTERVAL -3 DAY), NOW()),
       ('titi', 'role_user', 'user@user.com', 'test', ADDDATE(NOW(), INTERVAL -2 DAY), NOW()),
       ('tutu', 'role_user', 'user2@user2.com', 'test', ADDDATE(NOW(), INTERVAL -1 DAY), NOW());

INSERT INTO article(title,chapo,content,created_at, updated_at,id_user)
VALUES ('titre 1','chapo 1','content 1', ADDDATE(NOW(), INTERVAL -12 HOUR), NOW(),1),
       ('titre 2','chapo 2','content 2', ADDDATE(NOW(), INTERVAL -9 HOUR), NOW(),2),
       ('sans commentaire','chapo 3','content 3', NOW(), NOW(),1);

INSERT INTO comment(content, created_at, is_active, id_user, id_article)
VALUES ('comment 1', ADDDATE(NOW(), INTERVAL -8 HOUR), 1, 3, 1),
       ('comment 5', ADDDATE(NOW(), INTERVAL -7 HOUR), 0, 4, 1),
       ('comment 2', ADDDATE(NOW(), INTERVAL -6 HOUR), 1, 3, 1),
       ('comment 6', ADDDATE(NOW(), INTERVAL -5 HOUR), 1, 4, 1),
       ('comment 3', ADDDATE(NOW(), INTERVAL -4 HOUR), 1, 3, 1),
       ('comment 7', ADDDATE(NOW(), INTERVAL -3 HOUR), 0, 3, 2),
       ('comment 4', ADDDATE(NOW(), INTERVAL -2 HOUR), 1, 4, 2),
       ('comment 8', NOW(), 1, 3, 2);