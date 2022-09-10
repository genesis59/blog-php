USE blog_php;

INSERT INTO user(pseudo, role_users, email, pass, created_at, updated_at)
VALUES ('Anonyme', 'role_user', 'admin@admin.fr', 'test', ADDDATE(NOW(), INTERVAL -4 DAY), NOW()),
       ('toto', 'role_admin', 'admin@admin.com', 'test', ADDDATE(NOW(), INTERVAL -4 DAY), NOW()),
       ('tata', 'role_editor', 'editor@editor.com', 'test', ADDDATE(NOW(), INTERVAL -3 DAY), NOW()),
       ('titi', 'role_user', 'user@user.com', 'test', ADDDATE(NOW(), INTERVAL -2 DAY), NOW()),
       ('tutu', 'role_user', 'user2@user2.com', 'test', ADDDATE(NOW(), INTERVAL -1 DAY), NOW());

INSERT INTO article(title, chapo, content, created_at, updated_at, id_user)
VALUES ('Genshin Impact 3.0 : Le préchargement de la mise à jour est désormais disponible !',
        'La mise à jour 3.0 de Genshin Impact rajoutant la région de Sumeru arrive mercredi, mais les joueurs peuvent d''ores et déjà prè-télécharger le paquet de ressources. pour pouvoir jouer à la nouvelle version directement lorsqu''elle sera disponible.',
        'La version 3.0 arrive à grands pas sur Genshin Impact et comme à son habitude ; miHoYo nous propose de télécharger en avance les ressources de cette mise à jour via un pré-téléchargement disponible quelques jours avant la sortie officielle. Comme pour les précédents pré-téléchargements, ce sont les versions mobiles (iOS et Android) et PC qui seront concernées par cette fonctionnalité. Peut-être que la version PlayStation y aura le droit un jour qui sait ? En attendant, découvrons comment fonctionne ce pré-téléchargement.',
        ADDDATE(NOW(), INTERVAL -12 HOUR), NOW(), 2),
       ('10 conseils pour reprendre Genshin Impact avec la 3.0',
        'La 3.0 de Genshin Impact s''annonce déjà comme un patch phare du jeu de mihoyo. Avec la nouvelle région de Sumeru à explorer, c''est le moment où jamais de reprendre ce RPG seul ou avec des amis. Voici 10 astuces très simples pour bien progresser et farmer efficacement.',
        'Genshin Impact était devenu un RPG quelque peu ronflant depuis de nombreux mois, mais la mise à jour 3.0 du jeu va mettre un sacré coup de pied dans la fourmilière. Nouvelle région de Sumeru, nouvel attribut élémentaires, brochettes de personnages charismatiques... Les raisons de se replonger dans le RPG de mihoyo ne manquent pas. Aussi, on vous expose ici une liste qui synthétise 10 astuces clés pour reprendre le jeu dans les meilleures conditions, et parvenir à manager ses ressources sans tomber dans les pièges tendus par l''aspect gatcha du titre.',
        ADDDATE(NOW(), INTERVAL -8 HOUR), NOW(), 3),
       ('Genshin Impact 3.0 : focus sur Tighnari, date de sortie et compétences du nouveau personnage',
        'Le Marcheur verdoyant sera à la tête de la toute première bannière du patch de Sumeru. En tant que premier perso Dendro à voir le jour, Il mérite donc une attention toute particulière, à l''aube de cette fameuse version 3.0.',
        'Il est humble, amoureux de la nature, et manie le tout nouvel élément Dendro de Genshin Impact. Ce cher Tighnari a tout pour plaire ! Le Marcheur verdoyant sera d''ailleurs en vitrine de la bannière Viridescent Vigil, toute première bannière de personnage du patch 3.0, et il pourrait bien faire dépenser moultes primo-gemmes de par le monde.

MiHoyo a très récemment publié les dernières infos le concernant, qu''elles soient relatives à son histoire, son gameplay ou même des matériaux requis à son perfectionnement.',
        ADDDATE(NOW(), INTERVAL -7 HOUR), NOW(), 2),
       ('Genshin Impact live 3.0 : Sumeru, Tighnari, Collei, Dori.. Découvrez le récap des annonces',
        'Le live de la mise à jour 3.0 a eu lieu aujourd''hui et nous vous proposons de découvrir le récapitulatif des annonces. Tighnari, Collei, Dori, Sumeru ou encore les codes pour obtenir des primo-gemmes, nous vous dévoilons tout.',
        'La région de Sumeru nous réserve un environnement plutôt naturel en relation avec l''élément Dendro qui est introduit avec celle-ci. Si nous avions eu des détails sur la zone précédemment, nous avons pu avoir quelques précisions durant ce live.

Tout d''abord, vous devez savoir que la région de Sumeru se situe à l''ouest de Liyue et qu''elle se divise en deux parties. La première est la forêt tropicale et la seconde est le désert. À Sumeru, vous trouverez de multiples lieux à visiter comme la Ville du même nom ou encore le Port Ormos. La nation reconnue pour sa sagesse légendaire possède également une institution historique que l''on nomme "Académie". Elle a été fondée par des érudits de l''ancien Archon Dendro, la Molrani Rukkhadevata.

En parlant d''Archon, celle qui l''est actuellement est la Rani Kusanali. Elle lui a succédé i y a 500 ans, ce qui fait d''elle la plus jeune des Sept Archons à l''heure actuelle. Pour en revenir à l''Académie, c''est cette dernière qui gouverne la nation et qui a transformé la connaissance en une ressource gérée de manière rigoureuse.',
        ADDDATE(NOW(), INTERVAL -6 HOUR), NOW(), 3),
       ('Tower of Fantasy : King est-il un personnage copié de Genshin Impact ?',
        'Ils sont tous les deux grands, charismatiques, et portent une chevelure rouge flamboyante quasi identique. King et Diluc sont pour ainsi dire jumeaux... sauf qu''ils proviennent de deux titres différents, qui vont d''ailleurs se tirer la bourre sur le terrain des RPG gashapon.',
        'Comme on s''y attendait, ce mois d''aout est comme électrifié par la rivalité naissante entre Genshin Impact et Tower of Fantasy. Les deux RPG en monde ouvert emploient globalement la même marque de fabrique et les mêmes codes esthétiques, et ToF arrive sur la marché mondial avec la ferme intention de faire trembler Genshin Impact, bien en place depuis plus de deux ans.

Alors bien évidemment, les similitudes entre les deux univers sont légions. L''une d''elle titille tout particulièrement les communautés des deux titres : la ressemblance forte entre King et Diluc. "Ressemblance", le mot est peut-être même un peu faible. Les deux jeunes hommes manient l''élément du feu, le charisme, et la coupe de cheveu rouge comme personne.',
        ADDDATE(NOW(), INTERVAL -5 HOUR), NOW(), 1),
       ('Genshin Impact : Découvrez le nouvel événement intitulé Cadre mécanique perpétuel',
        'Genshin Impact : Découvrez le nouvel événement intitulé Cadre mécanique perpétuel', 'Maintenant que nous avons vu les informations relatives à votre participation, nous allons revenir brièvement sur ce qui vous attend dans cet événement. Tout d''abord, c''est auprès du PNJ Félix Yogue faisant partie de la Cour de Fontaine qu''il faudra prendre les instructions afin d''entamer votre quête pour récupérer les morceaux de cadre mécanique. Il faudra ensuite les restaurer en utilisant l''établi spécial de Félix. Pour finir, il faudra assembler le cadre mécanique. À noter qu''un morceau est débloqué quotidiennement. Attention à ne pas quitter l''interface lors du processus de restauration ou d''assemblage, car la progression ne se sauvegarde pas et il faut donc recommencer.', NOW(),
        NOW(), 2);

INSERT INTO comment(content, created_at, is_active, id_user, id_article)
VALUES ('comment 1', ADDDATE(NOW(), INTERVAL -8 HOUR), 1, 4, 1),
       ('comment 1', ADDDATE(NOW(), INTERVAL -8 HOUR), 1, 2, 1),
       ('comment 1', ADDDATE(NOW(), INTERVAL -8 HOUR), 1, 3, 1),
       ('comment 5', ADDDATE(NOW(), INTERVAL -7 HOUR), 0, 5, 1),
       ('comment 2', ADDDATE(NOW(), INTERVAL -6 HOUR), 1, 4, 1),
       ('comment 6', ADDDATE(NOW(), INTERVAL -5 HOUR), 1, 5, 1),
       ('comment 3', ADDDATE(NOW(), INTERVAL -4 HOUR), 1, 4, 1),
       ('comment 7', ADDDATE(NOW(), INTERVAL -3 HOUR), 0, 4, 2),
       ('comment 4', ADDDATE(NOW(), INTERVAL -2 HOUR), 1, 5, 2),
       ('comment 8', NOW(), 1, 4, 2);