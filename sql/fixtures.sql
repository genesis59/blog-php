USE blog_php;

INSERT INTO user(pseudo, role_users, email, pass, created_at, updated_at)
VALUES ('Anonyme', 'role_user', 'admin@admin.fr', 'test', ADDDATE(NOW(), INTERVAL -4 DAY), NOW()),
       ('toto', 'role_admin', 'admin@admin.com', 'test', ADDDATE(NOW(), INTERVAL -4 DAY), NOW()),
       ('tata', 'role_editor', 'editor@editor.com', 'test', ADDDATE(NOW(), INTERVAL -3 DAY), NOW()),
       ('titi', 'role_user', 'user@user.com', 'test', ADDDATE(NOW(), INTERVAL -2 DAY), NOW()),
       ('tutu', 'role_user', 'user2@user2.com', 'test', ADDDATE(NOW(), INTERVAL -1 DAY), NOW());

INSERT INTO article(title, chapo, content, created_at, updated_at, id_user)
VALUES ('Zoom in on API development with API Platform workshop at SymfonyCon Disneyland Paris 2022',
        'Discover the API development with API Platform one-day workshop organized at SymfonyCon Disneyland Paris 2022 on November 15 or 16.', 'The SymfonyCon Disneyland Paris 2022 event comes with 2 days of pre-conference workshops organized on November 15-16. All workshops will be organized in English at the Disney''s Newport Bay Club. We offer 10 different workshops per day, you can choose to be trained on 10 different topics related to Symfony and its ecosystem. It''s the best way to learn more about Symfony, the ecosystem and the latest features. Enjoying the workshops reinforce your knowledge and enable you to get the most out of the conference!

Discover in details the "API development with API Platform" workshop. It''s a 1-day workshop organized on both workshop days, on November 15 and 16. You have to choose one workshop session either on November 15 or 16. Your trainer is Kévin Dunglas, creator of the API Platform framework and Symfony Core Team member.

API Plaftorm has become a very popular framework for building advanced and modern API-driven web projects. This includes: - a super powerful server component based on Symfony to create hypermedia web APIs and GraphQL; - a generator of progressive web applications (ReactJS, Vue.js) and native mobile applications (React Native); - a ReactJS administration interface (ReactJS + admin on standby).

After an overview of the modern API models and formats (REST, Swagger, Hypermedia, HATEOAS, JSON-LD, Hydra, Schema.org, GraphQL...), we will learn how to use and extend the most popular features of the component: Swagger documentation, pagination, validation, sorting, filtering, authentication, authorization, content negotiation, data model generation using Schema.org vocabulary. Finally, we will discover how easy it is to use the client-side toolbox (JavaScript).

Interested in this workshop? Book now your API development with API Platform workshop ticket at SymfonyCon Disneyland Paris 2022, seats are limited and registration is based on first come first served!

Don''t miss the opportunity to attend this workshop! Enhance your skills at SymfonyCon Disneyland Paris 2022.',
        ADDDATE(NOW(), INTERVAL -12 HOUR), NOW(), 2),
       ('Zoom in on Profiling Symfony & PHP apps workshop at SymfonyCon Disneyland Paris 2022',
        'Discover the Profiling Symfony & PHP apps one-day workshop organized at SymfonyCon Disneyland Paris 2022 on November 15 or 16.', 'The SymfonyCon Disneyland Paris 2022 event comes with 2 days of pre-conference workshops organized on November 15-16. All workshops will be organized in English at the Disney''s Newport Bay Club. We offer 10 different workshops per day, you can choose to be trained on 10 different topics related to Symfony and its ecosystem. It''s the best way to learn more about Symfony, the ecosystem and the latest features. Enjoying the workshops reinforce your knowledge and enable you to get the most out of the conference!

Discover in details the "Profiling Symfony & PHP apps" workshop. It''s a 1-day workshop organized on both workshop days, on November 15 and 16. You have to choose one workshop session either on November 15 or 16. Your trainer is Jérôme Vieilledent, DevRel Engineer.

It is difficult to improve what is not measurable!

Profiling an application should always be the first step in trying to improve its performance. With this workshop, learn how to identify performance issues in your application and adopt the best profiling practices in your daily development habits. This workshop will use the Blackfire.io tool to help you identify performance leaks.

Interested in this workshop? Book now your Profiling Symfony & PHP apps workshop ticket at SymfonyCon Disneyland Paris 2022, seats are limited and registration is based on first come first served!

Don''t miss the opportunity to attend this workshop! Enhance your skills at SymfonyCon Disneyland Paris 2022.',
        ADDDATE(NOW(), INTERVAL -8 HOUR), NOW(), 3),
       ('Zoom in on Knowing your state machines - Symfony Workflow workshop at SymfonyCon Disneyland Paris 2022',
        'Discover the Knowing your state machines - Symfony Workflow one-day workshop organized at SymfonyCon Disneyland Paris 2022 on November 15 or 16.', 'The SymfonyCon Disneyland Paris 2022 event comes with 2 days of pre-conference workshops organized on November 15-16. All workshops will be organized in English at the Disney''s Newport Bay Club. We offer 10 different workshops per day, you can choose to be trained on 10 different topics related to Symfony and its ecosystem. It''s the best way to learn more about Symfony, the ecosystem and the latest features. Enjoying the workshops reinforce your knowledge and enable you to get the most out of the conference!

Discover in details the "Knowing your state machines - Symfony Workflow" workshop. It''s a 1-day workshop organized on both workshop days, on November 15 and 16. You have to choose one workshop session either on November 15 or 16. Your trainer is Tobias Nyholm, Symfony Core Team member.

Web development is not just about delivering a response, it is also about writing good code. The state pattern will help you move complexity from being all over your code to one or more state machines.

This workshop will introduce state machines, show you how to identify uses of them, and implement them in your Symfony application in an object-oriented manner using the Symfony Workflow component.

Interested in this workshop? Book now your Knowing your state machines - Symfony Workflow workshop ticket at SymfonyCon Disneyland Paris 2022, seats are limited and registration is based on first come first served!

Don''t miss the opportunity to attend this workshop! Enhance your skills at SymfonyCon Disneyland Paris 2022.',
        ADDDATE(NOW(), INTERVAL -7 HOUR), NOW(), 2),
       ('More conference replays available: relive our past conferences from 2020 in replay!',
        'Each conference from 2020 comes with a replay available for purchase after the conference! You missed a conference? Buy now a ticket replay for any conference you missed from 2020 and enjoy all the talks available: 140+ talks are available in replay!', 'Since 2020, each conference we organize comes with a complete replay available for all the conference attendees but also for purchase for anyone who missed the conference and would like to watch it. If you, unfortunately, were not able to attend one of our conferences from the last years, don''t worry, you can still buy a conference replay ticket to watch all the talks for any conference we organized in 2020, 2021, and 2022.

Our replay includes a total of 9 online conferences and 140+ talks about Symfony latest features and its ecosystem are waiting for you in replay! A fantastic way to learn more about Symfony at your own path with our great conference speakers and their talks!

To get the most out of our replay, all our online conferences replay available for over a year from today are at special price. Get your replay ticket for the following conferences at half the price of the regular replay price, meaning that for:

SymfonyWorld Online 2020: 30 talks in English, the conference replay is now at 60€ (price before was 119€). Buy your replay ticket now for SymfonyWorld Online 2020
SymfonyLive Online Polish Edition 2021: 10 talks in Polish, the conference replay is now at 40€ (price before was 79€). Buy your replay ticket now for SymfonyLive Online Polish Edition 2021
SymfonyLive Online French Edition 2021: 12 talks in French, the conference replay is now at 44€ (price before was 89€). Buy your replay ticket now for SymfonyLive Online French Edition 2021
SymfonyLive Online German Edition 2021: 12 talks in German, the conference replay is now at 44€ (price before was 89€). Buy your replay ticket now for SymfonyLive Online German Edition 2021
SymfonyLive Online Spanish Edition 2021: 11 talks in Spanish, the conference replay is now at 40€ (price before was 79€). Buy your replay ticket now for SymfonyLive Online Spanish Edition 2021
SymfonyWorld Online 2021 Summer Edition: 19 talks in English, the conference replay is now at 60€ (price before was 119€). Buy your replay ticket now for SymfonyWorld Online 2021 Summer Edition
You can also buy a replay ticket at regular replay price for:

SymfonyWorld Online 2021 Winter Edition: international online conference in English, 25 talks, at the regular replay price of 119€
SymfonyLive Paris 2022: French physical conference, 14 talks available, at the regular replay price of 149€
SymfonyWorld Online 2022 Summer Edition: international online conference in English, 18 talks available, at the regular replay price of 149€
Find the best conference replay you need to enhance your Symfony skills and relive our conferences like you attended it!',
        ADDDATE(NOW(), INTERVAL -6 HOUR), NOW(), 3),
       ('Zoom in on Building modular and interactive applications with Symfony UX workshop at SymfonyCon Disneyland Paris 2022',
        'Discover the Building modular and interactive applications with Symfony UX one-day workshop organized at SymfonyCon Disneyland Paris 2022 on November 15 or 16.', 'The SymfonyCon Disneyland Paris 2022 event comes with 2 days of pre-conference workshops organized on November 15-16. All workshops will be organized in English at the Disney''s Newport Bay Club. We offer 10 different workshops per day, you can choose to be trained on 10 different topics related to Symfony and its ecosystem. It''s the best way to learn more about Symfony, the ecosystem and the latest features. Enjoying the workshops reinforce your knowledge and enable you to get the most out of the conference!

Discover in details the "Building modular and interactive applications with Symfony UX" workshop. It''s a 1-day workshop organized on both workshop days, on November 15 and 16. You have to choose one workshop session either on November 15 or 16. Your trainer is Titouan Galopin, Symfony Core Team member, on November 15 and Ryan Weaver, Symfony Core Team member, Lead of its documentation, on November 16.

Building great User Experiences with JavaScript is difficult. It takes time to choose reliable packages, to configure them, to integrate them in your pages, and to make your front-end code interact with the rest of your infrastructure. In December 2020, Symfony unveiled a tool that helps on these regards: Symfony UX.

This workshop will introduce you to Symfony UX and the tools it relies on: Webpack Encore, Stimulus, Jest and Testing Library. We will discover how to build modular and interactive interfaces using small reusable JavaScript components that can be easily tested automatically. We will also discover how to rely on Symfony UX and Swup to build advanced User Experiences using the micro-frontends approach. Finally, we will discuss a little bit about React and how it can be used inside of your Symfony UX applications to increase even more its capabilities.

Interested in this workshop? Book now your Building modular and interactive applications with Symfony UX workshop ticket at SymfonyCon Disneyland Paris 2022, seats are limited and registration is based on first come first served!

Don''t miss the opportunity to attend this workshop! Enhance your skills at SymfonyCon Disneyland Paris 2022.',
        ADDDATE(NOW(), INTERVAL -5 HOUR), NOW(), 1),
       ('Zoom in on RESTful Webservices in Symfony workshop at SymfonyCon Disneyland Paris 2022',
        'Discover the RESTful Webservices in Symfony 2-day workshop organized at SymfonyCon Disneyland Paris 2022 on November 15-16.', 'The SymfonyCon Disneyland Paris 2022 event comes with 2 days of pre-conference workshops organized on November 15-16. All workshops will be organized in English at the Disney''s Newport Bay Club. We offer 10 different workshops per day, you can choose to be trained on 10 different topics related to Symfony and its ecosystem. It''s the best way to learn more about Symfony, the ecosystem and the latest features. Enjoying the workshops reinforce your knowledge and enable you to get the most out of the conference!

Discover in details the "RESTful Webservices in Symfony" workshop. It''s a 2-day workshop organized on November 15 and 16. Your trainer is Jan Schädlich, Lead Developer PHP/Symfony.

Nowadays RESTful Apis are powering the web and are used in almost every web application. In this workshop you will learn the fundamental principles of REST and how you can implement a RESTful Application using Symfony. We will start with the basics of REST, continue with some more advanced topics like Serialization, Content-Negotiation and Security (OAuth 2, JWT) and eventually talk about Documentation and Versioning of APIs. Besides all the theory the attendees can deepen their learnings on every topic while doing the provided coding challenges.

Interested in this workshop? Book now your RESTful Webservices in Symfony workshop ticket at SymfonyCon Disneyland Paris 2022, seats are limited and registration is based on first come first served!

Don''t miss the opportunity to attend this workshop! Enhance your skills at SymfonyCon Disneyland Paris 2022.', NOW(),
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