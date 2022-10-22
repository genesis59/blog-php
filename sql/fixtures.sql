USE blog_php;
INSERT INTO user(pseudo, role_users, email, pass, created_at, updated_at)
VALUES ('Anonyme', 'role_anonyme', 'anonyme@anonyme.fr',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-20 16:36:19', '2022-08-20 16:36:19'),
       ('Simon', 'role_admin', 'admin@admin.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-21 17:49:19', '2022-08-21 17:49:19'),
       ('Arthur', 'role_editor', 'editor@editor.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-22 20:21:19', '2022-08-22 20:21:50'),
       ('Karen', 'role_editor', 'editor2@editor.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-23 09:50:19', '2022-08-23 16:36:19'),
       ('Jean', 'role_editor', 'editor3@editor.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-24 16:10:19', '2022-08-24 16:10:19'),
       ('Cathy', 'role_editor', 'editor4@editor.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-25 06:57:19', '2022-08-25 06:57:19'),
       ('Victoire', 'role_user', 'user@user.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-26 08:36:19', '2022-08-26 08:36:19'),
       ('Bernard', 'role_user', 'user2@user.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-27 12:39:19', '2022-08-30 12:39:19'),
       ('Aurore', 'role_user', 'user3@user.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-28 16:22:19', '2022-08-28 16:22:19'),
       ('Manu', 'role_user', 'user4@user.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-29 18:57:19', '2022-08-29 18:59:19'),
       ('Phil', 'role_user', 'user5@user.com',
        '$argon2i$v=19$m=65536,t=4,p=1$ckxBTVpUdGVzTngzN3hCbg$hGt7lkQw2dsF9dsskfu0TYC17JyT5fiIB9ddz0FTMSA',
        '2022-08-30 04:06:19', '2022-08-30 04:06:19');

INSERT INTO article(slug,title, chapo, content, created_at, updated_at, id_user)
VALUES ('slug-article-0','Genshin Impact 3.0 : Le préchargement de la mise à jour est désormais disponible !',
        'La mise à jour 3.0 de Genshin Impact rajoutant la région de Sumeru arrive mercredi, mais les joueurs peuvent d''ores et déjà prè-télécharger le paquet de ressources. pour pouvoir jouer à la nouvelle version directement lorsqu''elle sera disponible.',
        'La version 3.0 arrive à grands pas sur Genshin Impact et comme à son habitude ; miHoYo nous propose de télécharger en avance les ressources de cette mise à jour via un pré-téléchargement disponible quelques jours avant la sortie officielle. Comme pour les précédents pré-téléchargements, ce sont les versions mobiles (iOS et Android) et PC qui seront concernées par cette fonctionnalité. Peut-être que la version PlayStation y aura le droit un jour qui sait ? En attendant, découvrons comment fonctionne ce pré-téléchargement.',
        '2022-09-02 04:06:19', '2022-09-03 08:12:19', 2),
       ('slug-article-1','10 conseils pour reprendre Genshin Impact avec la 3.0',
        'La 3.0 de Genshin Impact s''annonce déjà comme un patch phare du jeu de mihoyo. Avec la nouvelle région de Sumeru à explorer, c''est le moment où jamais de reprendre ce RPG seul ou avec des amis. Voici 10 astuces très simples pour bien progresser et farmer efficacement.',
        'Genshin Impact était devenu un RPG quelque peu ronflant depuis de nombreux mois, mais la mise à jour 3.0 du jeu va mettre un sacré coup de pied dans la fourmilière. Nouvelle région de Sumeru, nouvel attribut élémentaires, brochettes de personnages charismatiques... Les raisons de se replonger dans le RPG de mihoyo ne manquent pas. Aussi, on vous expose ici une liste qui synthétise 10 astuces clés pour reprendre le jeu dans les meilleures conditions, et parvenir à manager ses ressources sans tomber dans les pièges tendus par l''aspect gatcha du titre.',
        '2022-09-02 06:06:19', '2022-09-02 06:06:19', 3),
       ('slug-article-2','Genshin Impact 3.0 : focus sur Tighnari, date de sortie et compétences du nouveau personnage',
        'Le Marcheur verdoyant sera à la tête de la toute première bannière du patch de Sumeru. En tant que premier perso Dendro à voir le jour, Il mérite donc une attention toute particulière, à l''aube de cette fameuse version 3.0.',
        'Il est humble, amoureux de la nature, et manie le tout nouvel élément Dendro de Genshin Impact. Ce cher Tighnari a tout pour plaire ! Le Marcheur verdoyant sera d''ailleurs en vitrine de la bannière Viridescent Vigil, toute première bannière de personnage du patch 3.0, et il pourrait bien faire dépenser moultes primo-gemmes de par le monde.

MiHoyo a très récemment publié les dernières infos le concernant, qu''elles soient relatives à son histoire, son gameplay ou même des matériaux requis à son perfectionnement.',
        '2022-09-04 19:42:19', '2022-09-04 19:42:19', 2),
       ('slug-article-3','Genshin Impact live 3.0 : Sumeru, Tighnari, Collei, Dori.. Découvrez le récap des annonces',
        'Le live de la mise à jour 3.0 a eu lieu aujourd''hui et nous vous proposons de découvrir le récapitulatif des annonces. Tighnari, Collei, Dori, Sumeru ou encore les codes pour obtenir des primo-gemmes, nous vous dévoilons tout.',
        'La région de Sumeru nous réserve un environnement plutôt naturel en relation avec l''élément Dendro qui est introduit avec celle-ci. Si nous avions eu des détails sur la zone précédemment, nous avons pu avoir quelques précisions durant ce live.

Tout d''abord, vous devez savoir que la région de Sumeru se situe à l''ouest de Liyue et qu''elle se divise en deux parties. La première est la forêt tropicale et la seconde est le désert. À Sumeru, vous trouverez de multiples lieux à visiter comme la Ville du même nom ou encore le Port Ormos. La nation reconnue pour sa sagesse légendaire possède également une institution historique que l''on nomme "Académie". Elle a été fondée par des érudits de l''ancien Archon Dendro, la Molrani Rukkhadevata.

En parlant d''Archon, celle qui l''est actuellement est la Rani Kusanali. Elle lui a succédé i y a 500 ans, ce qui fait d''elle la plus jeune des Sept Archons à l''heure actuelle. Pour en revenir à l''Académie, c''est cette dernière qui gouverne la nation et qui a transformé la connaissance en une ressource gérée de manière rigoureuse.',
        '2022-09-05 15:18:19', '2022-09-05 16:19:19', 3),
       ('slug-article-4','Tower of Fantasy : King est-il un personnage copié de Genshin Impact ?',
        'Ils sont tous les deux grands, charismatiques, et portent une chevelure rouge flamboyante quasi identique. King et Diluc sont pour ainsi dire jumeaux... sauf qu''ils proviennent de deux titres différents, qui vont d''ailleurs se tirer la bourre sur le terrain des RPG gashapon.',
        'Comme on s''y attendait, ce mois d''aout est comme électrifié par la rivalité naissante entre Genshin Impact et Tower of Fantasy. Les deux RPG en monde ouvert emploient globalement la même marque de fabrique et les mêmes codes esthétiques, et ToF arrive sur la marché mondial avec la ferme intention de faire trembler Genshin Impact, bien en place depuis plus de deux ans.

Alors bien évidemment, les similitudes entre les deux univers sont légions. L''une d''elle titille tout particulièrement les communautés des deux titres : la ressemblance forte entre King et Diluc. "Ressemblance", le mot est peut-être même un peu faible. Les deux jeunes hommes manient l''élément du feu, le charisme, et la coupe de cheveu rouge comme personne.',
        '2022-09-05 18:06:19', '2022-09-05 18:06:19', 1),
       ('slug-article-5','Genshin Impact : Découvrez le nouvel événement intitulé Cadre mécanique perpétuel',
        'Genshin Impact : Découvrez le nouvel événement intitulé Cadre mécanique perpétuel',
        'Maintenant que nous avons vu les informations relatives à votre participation, nous allons revenir brièvement sur ce qui vous attend dans cet événement. Tout d''abord, c''est auprès du PNJ Félix Yogue faisant partie de la Cour de Fontaine qu''il faudra prendre les instructions afin d''entamer votre quête pour récupérer les morceaux de cadre mécanique. Il faudra ensuite les restaurer en utilisant l''établi spécial de Félix. Pour finir, il faudra assembler le cadre mécanique. À noter qu''un morceau est débloqué quotidiennement. Attention à ne pas quitter l''interface lors du processus de restauration ou d''assemblage, car la progression ne se sauvegarde pas et il faut donc recommencer.',
        '2022-09-06 20:46:19',
        '2022-09-06 20:46:19', 2),
       ('slug-article-6','Version 3.1 de Genshin Impact  : Voyage à travers le désert',
        'Explorez le vaste désert de Sumeru en compagnie de Candace, Cyno et Nilou  ! Profitez du Weinlesefest avec vos amis à Mondstadt  !',
        'Bonjour voyageurs ! Ici l’équipe de développement de Genshin Impact, nous avons le plaisir aujourd’hui de vous en dévoiler davantage sur la version 3.1 « Le roi Deshret et les trois mages ». Nous allons cette fois traverser la forêt tropicale vers l’ouest et entrer dans le magnifique désert pour y découvrir les légendes du roi Deshret ainsi que les indices du passé enfouis dans le sable. Trois nouveaux personnages de Sumeru rejoignent la liste des personnages jouables : Candace, Cyno et Nilou. Loin du sable étouffant, la célébration du Weinlesefest se présente dans le vent frais de l’automne avec davantage d’événements, de mini-jeux et de nombreuses récompenses.

La zone de la mort, du mystère et de la technologie
Contrairement à la forêt tropicale verdoyante, le désert de Sumeru ressemble à première vue à une vaste étendue de vide. On trouve au centre de ce désert le gigantesque Mausolée du roi Deshret. Bien que le roi Deshret et sa civilisation ancienne aient déjà disparu, ses légendes et sa technologie sont toujours mentionnées par le peuple du désert. On y trouve encore des mécanismes et des robots qui gardent sa dernière demeure.',
        '2022-09-07 05:06:19', '2022-09-07 05:45:19', 4),
       ('slug-article-7','Genshin Impact Version 2.8, « Songerie d’une nuit d’été », sera disponible le 13 Juillet',
        'Profitez de l''été en compagnie de vos compagnons et de Shikanoin Heizou, d''une toute nouvelle aventure dans les îles, de nouvelles histoires et de magnifiques tenues !',
        'Bonjour, chers voyageurs ! L’équipe de développement de Genshin Impact est de retour pour vous inviter à profiter de l’été en Teyvat avec la version 2.8 de Genshin Impact «Songerie d’une nuit d’été» disponible le 13 juillet ! L’Archipel de la pomme dorée est à nouveau ouvert aux gens de l’extérieur, arborant un nouveau look avec davantage d’histoires, de défis et de récompenses. Préparez-vous à plonger dans des royaumes que vous n’avez jamais visités et découvrez la face cachée de vos compagnons. Un an après son apparition en jeu, vous aurez le plaisir d’en découvrir davantage sur Kaedehara Kazuha lorsque vous embarquerez dans la quête d’histoire de ce samouraï vagabond. Son ami proche Shikanoin Heizou sera aussi de la partie.

Séjour estival à la mer
En comparaison aux précédentes aventures insulaires, le «Séjour estival à la mer» de cette année vous réserve encore plus de surprises, maintenant que l’Archipel de la pomme dorée arbore un nouveau look : de nouveaux paysages et de nombreuses histoires à découvrir au fil de l’événement, de généreuses récompenses qui incluent un grand nombre de coffres et l’opportunité d’obtenir le personnage 4 étoiles Fischl, ainsi que sa toute nouvelle tenue. Tous ces éléments seront disponibles pendant une durée limitée.',
        '2022-09-08 13:28:19', '2022-09-08 13:28:19', 6),
       ('slug-article-8','Genshin Impact Version 2.6  : Aventurez-vous dans le Gouffre',
        'Découvrez les mystères tapis dans les profondeurs du Gouffre, rencontrez Kamisato Ayato et célébrez votre premier Festival Irodori à Inazuma en compagnie d''amis venus de tout Teyvat !',
        'Bonjour, chers voyageurs ! Nous avons le plaisir aujourd’hui de partager avec vous les dernières informations à propos de la version 2.6 de Genshin Impact « Zéphyr sur le jardin violet », qui sera officiellement disponible le 30 mars. La nouvelle zone vous permettra d’explorer la partie la plus à l’ouest de Liyue, de plonger dans cet étrange endroit et de continuer l’histoire des jumeaux voyageurs en compagnie de Dainsleif. De l’autre côté de la mer, la vie à Inazuma a bien changé depuis l’abolition du décret de confinement. Le magnifique Festival Irodori verra de nombreux invités d’Inazuma et de l’étranger venir célébrer les arts et la culture. Kamisato Ayato, le jeune maître qui a fait entrer l’un des clans les puis puissants d’Inazuma dans une nouvelle ère, sera disponible en tant que personnage cinq étoiles et le protagoniste d’une intéressante quête d’histoire.

Dans le Gouffre

Le Gouffre a longtemps été la principale source de minerai de Liyue, particulièrement pour la fabrication de sa célèbre porcelaine. Vu d’en haut, le sol de cette zone arbore une teinte rouge-violet. De mystérieux accidents ont entraîné la récente fermeture de toute cette zone. Vous pourrez cependant, en tant que voyageur, rejoindre une équipe d’experts de différents domaines pour découvrir ce qui se passe dans ces profondeurs.',
        '2022-09-09 18:18:19', '2022-09-09 18:18:19', 4),
       ('slug-article-9','Genshin Impact version 2.5 : Rejoignez Yae Miko et la Shogun Raiden quand les sakura fleurissent',
        'Repoussez les ténèbres d''Enkanomiya, faites équipe avec Yae Miko et la Shogun Raiden et partagez les donjons que vous avez conçus avec les autres voyageurs  !',
        'Bonjour, chers voyageurs ! Ici, l’équipe de développement de Genshin Impact. Nous souhaitons aujourd’hui vous montrer quelque chose en rapport avec la mise à jour de version 2.5 « Quand les sakura fleurissent » qui sera disponible le 16 février ! Yae Miko rejoint enfin la liste des personnages jouables. Sa quête d’histoire ainsi que la suite de celle de la Shogun Raiden seront aussi disponibles, dévoilant le passé qui les lie à Inazuma depuis des centaines d’années. Pendant ce temps, des ténèbres d’origine inconnue envahissent Enkanomiya. Prêtez main forte à Kokomi afin de découvrir la vérité ! En plus des aventures que nous vous avons préparées, vous pourrez également élaborer vos propres modes de jeu ! Découvrez l’événement « Ingéniosité divine » et créez vos propres donjons ou essayez ceux des autres ! Repoussez les ténèbres qui envahissent Enkanomiya
Les aventuriers expérimentés ont certainement déjà exploré Enkanomiya, une nation antique immergée laissée pour compte pendant des milliers d’années. Dans l’événement « Offrande d’accès aux Trois Royaumes », une zone basée sur Enkanomiya mais hantée par des ténèbres d’origine inconnue vous mettra au défi grâce à un tout nouveau mode de jeu. Nous avons aussi quelques conseils à vous donner.',
        '2022-09-10 23:00:19', '2022-09-10 23:00:19', 5),
       ('slug-article-10','Genshin Impact Version 2.4 Une grande fête et une nouvelle zone mystérieuse pour le nouvel an en Teyvat',
        'Célébrez le Festival des lanternes de Liyue en compagnie de nouveaux et de vieux amis, puis démarrez une nouvelle année remplie d''aventures dans la nouvelle zone d''Enkanomiya !',
        'Bonjour, voyageurs ! J’ai le plaisir de vous présenter en compagnie de l’équipe de développeurs la version 2.4 « Couleurs éphémères en vol », la première mise à jour de 2022 qui sera disponible le 5 janvier. Alors que la nouvelle année approche également en Teyvat, nous souhaitons vous inviter au Festival des lanternes de Liyue pour vous joindre à Shenhe, Yun Jin et de vieux amis pour reconstruire la Chambre de Jade. Vous pourrez obtenir de généreuses récompenses, y compris 10 pierres de la fatalité et un personnage 4 étoiles de Liyue gratuitement. À ces bonnes nouvelles s’ajoute un nouveau royaume enfoui sous les eaux calmes de l’Île de Watatsumi. Scellée pendant des milliers d’années, l’Enkanomiya maintenant éveillée a besoin d’un héros.

Reconstruction et réjouissance au Festival des lanternes
Le Festival des lanternes est la fête annuelle la plus importante de Liyue, un moment particulier où les gens se réunissent pour honorer les disparus et embrasser l’avenir avec leurs meilleurs vœux. Le jour des célébrations, le ciel du Port de Liyue s’illumine de lanternes célestes libérées par chaque foyer, avant d’accueillir un feu d’artifice grandiose.',
        '2022-09-11 10:04:19', '2022-09-11 10:04:19', 5),
       ('slug-article-11','Genshin Impact version 2.3 stage d’hiver dans les Monts Dosdragon !',
        'Relevez les défis des Monts Dosdragon et découvrez l''hiver en Teyvat avec Albedo, Eula, Arataki Itto et Gorou !',
        'Bonjour voyageurs ! L’équipe de développeurs de Genshin Impact est de retour avec les dernières informations à propos de la mise à jour de version 2.3 « Ombres au cœur du blizzard » qui sera disponible le 24 novembre. L’hiver arrive en Teyvat et nous avons préparé une série de défis et d’activités dans la neige à travers les Monts Dosdragon. Pendant ce temps à Inazuma, l’Agence de détectives Bantan Sango est confrontée à une mission urgente à propos de disparitions massives de petits animaux. Dans la version 2.3, des nouveaux et anciens compagnons rejoindront l’aventure. Albedo et Eula feront leur retour, tandis qu’Arataki Itto et Gorou feront leur apparition en jeu comme nouveaux personnages jouables. Entraînement dans le grand froid
Couverts de neige tout au long de l’année, les Monts Dosdragon est une énorme chaîne de montagnes au sud de Mondstadt. Dans l’événement « Ombres au cœur du blizzard » de cette saison, la Guilde des aventuriers y organise un stage d’hiver. De vieilles connaissances, comme Albedo et Eula, apparaîtront dans l’histoire. Il est l’heure de rafraîchir vos compétences, de profiter de la neige et d’obtenir des récompenses comme la nouvelle épée 4★ « Fuseau de cinabre » pour perfectionner vos personnages !',
        '2022-09-12 20:59:19', '2022-09-12 20:59:19', 4),
       ('slug-article-12','Genshin Impact Version 2.2 Dissipez la brume mystique qui enveloppe l’île de Tsurumi',
        'Explorez la dernière des îles principales d''Inazuma et relevez de nouveaux défis avec Thomas, Tartaglia, Xinyan et Hu Tao  !',
        'Bonjour, chers voyageurs ! Une fois de plus, l’équipe de développement de Genshin Impact vient vous communiquer les informations les plus récentes sur la dernière mise à jour du jeu. La version 2.2 « Dans les méandres de la brume » qui arrive le 13 octobre vous fera découvrir la dernière des six îles principales d’Inazuma, un nouveau personnage jouable, Thomas, et une escapade avec ce dernier. En plus de cela, vous pourrez également relever de nouveaux défis à Inazuma avec Tartaglia et Xinyan, ou tout simplement passer de bons moments avec de vieux amis à Liyue, Mondstadt, ou dans votre royaume intérieur.

Par ailleurs, si vous n’avez pas encore reçu le personnage 5★ gratuit Aloy « Salvatrice d’un autre monde », n’oubliez pas de le récupérer dans la version 2.2. Vous pouvez également obtenir « Predator », un arc spécial conçu sur mesure pour Aloy, et commencer à chasser avec elle dans le monde de Teyvat. Une île dans la brume
Les principales îles d’Inazuma ont chacune leurs particularités, mais l’Île de Tsurumi est peut-être la plus difficile à visiter pour les vagabonds et les explorateurs. L’épais brouillard qui recouvre toute l’île repousse la plupart des étrangers. Vous devrez trouver votre chemin et faire attention à ne pas vous perdre.',
        '2022-09-13 14:06:19', '2022-09-13 14:06:19', 6),
       ('slug-article-13','Genshin Impact Version 2.1 Partez à la chasse avec Aloy dans le monde de Teyvat !',
        'Visitez à nouveau Liyue pour le Festival de désilune, rencontrez de nouveaux amis et apprêtez-vous à clore l''histoire principale d''Inazuma !',
        'Bonjour, voyageurs ! Ici, l’équipe de développement de Genshin Impact. Nous espérons que vous avez apprécié explorer Inazuma en juillet ! Avec la version 2.1 « Caresse sélénite sur les mortels » qui sortira le 1er septembre, de nouvelles îles et de nouvelles histoires vous attendent. Bien évidemment, de nouveaux personnages jouables feront leur apparition et vous aurez même l’occasion de revoir vos vieux amis du Port de Liyue.

Pendant ce temps, Aloy, la chasseuse nora légendaire du jeu Horizon Zero Down, répond à l’appel de l’aventure en Teyvat pour s’embarquer dans de nouvelles péripéties. Si vous parvenez à atteindre le niveau d’aventure 20 pendant les versions 2.1 et 2.2 de Genshin Impact, vous aurez la chance de recevoir Aloy « Salvatrice d’un autre monde », personnage 5★ issu d’une collaboration exclusive, ainsi que son arc 4★ « Predator » par messagerie en vous connectant à Genshin Impact sur PS4 ou PS5 ! Aloy « Salvatrice d’un autre monde »
Lors de son voyage vers Teyvat, Aloy s’est vu accorder un œil divin Cryo, lui permettant donc d’ajouter des cordes à son arc. En libérant son déchaînement élémentaire « Prophéties de l’aube », Aloy lance une batterie Cryo dans la direction ciblée, puis la fait exploser avec une flèche, ce qui inflige d’importants dégâts de zone Cryo. Sa compétence élémentaire et ses aptitudes confèrent des bonus aux autres personnages de l’équipe et à elle-même, tout en baissant les stats des ennemis qui subissent aussi des dégâts Cryo.

Quand Aloy utilise sa compétence élémentaire « Frozen Wilds », elle lance une bombe à gel qui explose à l’impact dans la direction ciblée, infligeant des dégâts Cryo. Après avoir explosé, la bombe à gel se divise en de nombreuses petites bombes glacées qui explosent au contact des ennemis ou après un court délai, infligeant des dégâts Cryo supplémentaires. Lorsqu’une bombe à gel ou une petite bombe glacée touche un ennemi, les points d’attaque de ce dernier sont réduits. Aloy obtient également 1 charge de bobine qui augmente les dégâts de ses attaques normales. Une fois que son aptitude « Surcharge offensive » est débloquée, elle est même capable d’augmenter les points d’attaque de l’équipe pour une certaine durée lorsqu’elle est sous l’effet d’une bobine.

Avec 4 charges de bobine, Aloy consomme toutes les charges de bobine pour entrer dans un état de Glace précipitée, qui convertit les dégâts infligés par ses attaques normales en dégâts Cryo pendant une certaine durée. Si elle débloque l’aptitude passive « Frappe puissante », les dégâts Cryo infligés sous l’état de Glace précipitée augmentent de manière constante.

L’arc 4★ « Predator » décuple la puissance d’Aloy grâce à son effet unique. Cette arme, qu’elle a rapporté d’un autre monde, peut lui conférer 66 points d’attaque supplémentaires. Après avoir infligé des dégâts Cryo, son manieur a droit à un bonus de dégâts de 10 % pour ses attaques normales et chargées d’une durée de 6 secondes. Predator ne peut être obtenu que sur PS4 et PS5, mais il peut être utilisé sur les autres plateformes grâce à la synchronisation de la progression de jeu. Néanmoins, l’effet de l’arme est seulement actif sur les consoles PlayStation.',
        '2022-09-14 09:29:19', '2022-09-15 01:54:19', 1);

INSERT INTO comment(content, created_at, is_active, id_user, id_article)
VALUES ('En 24h tu arrive à finir les quêtes Archons, avoir 10000 primo-gemmes, explorer presque entièrement la map (sans compter inazuma), et moi en 24h j''avais a peine compris le fonctionnement du jeu j''ai qu''une chose a te dire gg', '2022-09-15 09:55:19', 1, 4, 1),
       ('Malgré le nombre de primo assez inférieur à l''attente voulu, tout ce que tu as fait c''est une performance tout de même remarquable. Jamais j''aurai été capable de faire tout ça moi ', '2022-09-15 10:45:19', 1, 2, 1),
       ('Franchement dès que t’avais annoncé le concept en live j’étais à fond dedans, trop content que tu l’ai réalisé, j’attendais la vidéo avec impatience et super comme d’hab on est pas déçus. Avec ta bonne humeur en plus ça fait trop plaisir :))', '2022-09-15 11:37:19', 1, 3, 1),
       ('Niveau d''aventure 32 en 24h tu m''a quasiment rattrapé ! Sinon le défi à dû être plutôt dur à réaliser j''ai aimé ce concept ', '2022-09-15 12:54:19', 0, 5, 1),
       ('Concept intéressant et utile. Un bon résultat, même si je pense qu''il y a moyen de faire encore mieux si on optimise à fond, mais ça reste très bien et représentatif, je pense. Bien joué et merci !', '2022-09-15 13:15:19', 1, 4, 1),
       ('Ce concept est super, il montre tout les primo que l’on perd quand on commence. Ça donne envie de recommencer mais on aura moins de motivation à la 2e fois. Merci pour t’es vidéo, conseil et guide perso', '2022-09-15 14:21:19', 1, 5, 1),
       ('Tu fais vraiment des concepts de ouf sur la chaîne continue comme sa c’est bien d’avoir d’autre vidéo que celle où tu donnes des infos !!', '2022-09-16 05:45:19', 0, 6, 1),
       ('Tu es à fond dans tous tes concepts et je trouve ça super cool, tu inoves et tu essayes de jouer à genshin différemment, c''est plutôt intéressant', '2022-09-16 09:12:19', 0, 7, 2),
       ('C’est de super bon conseils pour les gens qui commencent genshin et je t’encourage à continuer. Pour être franc si on pouvais pas descendre d’un niveau le niveau de monde, je serais en train de galérer à Monts dosdragon :’) J’aurais aimé découvrir ta chaîne plus tôt', '2022-09-16 13:43:19', 1, 5, 3),
       ('je trouve ce concepte super intéressant et originale! Hâte de voir ce que tu nous réserve pour après!', '2022-09-16 15:32:19', 1, 8, 9),
       ('Ce concept est vraiment bien! Tu explores toutes les possibilités pour avoir des primos :) Merci de nous faire ce genre de vidéo  tu gères', '2022-09-16 16:25:19', 1, 9, 4),
       ('Vraiment j''admire ta motivation pour toute l''exploitation', '2022-09-16 20:32:19', 1, 4, 9),
       ('J’ai vraiment trop aimé ce concept , j’ai suivi le défi en live et ça m’a vraiment donné envie  de re-créer un compte pour faire exactement pareil ! J’pense que ça aidera bcp les nouveaux joueurs ', '2022-09-17 15:46:19', 1, 10, 13),
       ('Yo , merci pour ce concept très intéressant :D C''est très sympa de ta part d''aider les nouveaux joueurs (;', '2022-09-17 16:23:19', 1, 10, 3),
       ('Sympa comme concept, j''ai bien aimé ! Un petit récapitulatif à la fin de ce qui t''as donné le plus de primo selon toi ça aurait été cool, même si on a compris que c''est surtout l''exploration. En tout cas merci pour ton taf ;)', '2022-09-17 17:51:19', 1, 2, 12),
       ('Merci beaucoup  pour cette video qui change des soluces, flex ou infos futurs ^^. Merci d''avoir ce défi, vivement la suivante', '2022-09-17 20:52:19', 0, 3, 4),
       ('Je trouve le concept grave intéressant et en plus sa peut aider les nouveaux joueurs à savoir comment trouve des primos :D et aussi c''est super sympa de ta part de faire un concours surtout que beaucoup de gens ne peuvent pas se permettre d''acheter une faveur de l''astre ^^', '2022-09-18 02:58:19', 1, 4, 3),
       ('Tu fais que des bons concept je trouve ca incroyable car ça m''aide énormément !', '2022-09-18 03:34:19', 1, 5, 4),
       ('Toujours aussi incroyable t’es concept ça peut vrm aider des gens continue comme ça ;)', '2022-09-18 04:16:19', 1, 6, 3),
       ('Super défi, très original et utile pour les nouveaux joueurs ! bravo pour le travail fourni !', '2022-09-18 15:48:19', 1, 7, 8),
       ('C''est hyper intéressant! Et franchement quel courage, même si tu l''as pas fait d''une traite le fait de tout recommencer depuis le début c''est long quand même', '2022-09-18 18:01:19', 0, 8, 5),
       ('C’est vraiment cool que tu fasse ce genre de vidéo ! Ça permet a beaucoup de s’informé facilement (dont moi) et pourtant ça doit quand même être du boulot pour ces vidéos donc merci beaucoup !', '2022-09-18 20:58:19', 1, 9, 6),
       ('tu fais toujours des concours, c’est vrm hyper généreux!! Et utile pour les f2p', '2022-09-18 22:36:19', 1, 10, 1),
       ('Franchement GG,en 24H tu a quand même réussi a obtenir un max de primo même si tu n''''a pas atteint l''objectif final c''est quand même énorme', '2022-09-18 23:47:19', 1, 11, 6),
       ('J’aime trop le concept c’est grave bien ! C’est quand même dommage de pas avoir atteins les 20k mais t’y étais presque hâte de voir la prochaine partie :)', '2022-09-18 23:29:19', 1, 2, 14),
       ('Les concepts de vidéos sont toujours incroyable ! Continue , c’est un vrai régal', '2022-09-18 23:30:19', 1, 3, 12),
       ('Hâte de voir tes prochaines vidéos merci de m''aider à m''améliorer sur genshin, tes petites astuces sont juste incroyable et clean, encore merci', '2022-09-18 23:32:19', 1, 4, 3),
       ('Le concept est vraiment sympa et ça nous indique où on aurait pu oublier des primo-gemmes.', '2022-09-18 23:33:19', 1, 5, 3),
       ('Tes vidéos sont très sympa et tes lives très chill franchement j''adore ce que tu fais, tu mérite plus de visibilité', '2022-09-18 23:45:19', 1, 6, 4),
       ('C''est cool ce genre de concept, ça change et ça apporte un peu plus de contenu au jeu ^^', '2022-09-18 23:48:19', 1, 7, 14),
       ('Salut, super vidéo! Juste dommage qu''il faut recommencer le jeu dès le début xD Je participe au concours', '2022-09-19 12:12:19', 1, 8, 7),
       ('Super concept ! C''est giga intéressant de savoir le nombre de primo gemmes qu''on peut avoir en lançant le jeu. Car pour les débutants, il y en a beaucoup qui dépensent rapidement et du coup empêche de savoir le nombre possible d''avoir depuis le début du jeu', '2022-09-19 14:47:19', 1, 9, 5),
       ('Merci pour ce concept très intéressant ! Cela permets de mieux visualiser, pour les nouveaux joueurs ou même ceux qui ont l''intention de se replonger dans l''aventure, le nombre de primogems qu''on peut farm.', '2022-09-19 15:54:19', 0, 10, 12),
       ('Super concept comme d''habitude et ca peut être très utile pour se donner une idée des primo que l''on peut récupérer au début du jeu !', '2022-09-19 16:49:19', 0, 11, 8),
       ('J''adore vraiment les concepts que tu fais j''espère que tu feras ça plus souvent :D continue comme ça t''es le boss', '2022-09-19 20:59:19', 1, 2, 4),
       ('Merci pour les conseils ( j’ai besoin de la faveur !!!)', '2022-09-19 22:21:19', 1, 3, 5),
       ('Concept incroyable ! Merci pour ce contenu de qualité que tu proposes', '2022-09-20 20:52:19', 1, 4, 2),
       ('Ouah incroyable le concept ! Merci beaucoup pour toutes tes vidéos si bien construites !', '2022-09-20 21:32:19', 1, 5, 2),
       ('Tu fais vraiment pleins de nouveaux concepts sur ta chaîne et franchement continue comme ça parce que c’est génial !!', '2022-09-20 22:25:19', 0, 6, 5),
       ('Ta des concepts de fou ! C’est vraiment intéressant je pense que ça serait cool que tu fasse un truc du genre en combien de temps on explore une des 3 zones principales je trouve ça intéressant pour savoir combien de temps de jeu ajoute Genshin tt les ans', '2022-09-20 23:23:19', 0, 8, 10),
       ('J’ai suivis les streams et c’est vrm un plaisir de te voir jouer et tester des trucs ^^', '2022-09-21 06:28:19', 0, 9, 6),
       ('Excellent concept comme toujours et c’est toujours aussi dynamique et interrompu que d’habitude !!!', '2022-09-21 09:25:19', 0, 5, 13),
       ('Content de voir de challenge comme ça en français sur genshin, ça change du jeu de base même si, il est déjà incroyable !', '2022-09-22 10:47:19', 0, 10, 14),
       ('J’aime beaucoup tes concepts sur ta chaîne et lui aussi ça nous permet de nous faire une idée. Continue comme ça !', '2022-09-22 11:41:19', 0, 11, 5);
