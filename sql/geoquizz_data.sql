INSERT INTO `serie` (`id`, `ville`, `latitude`, `longitude`, `distance`, `temps`, `zoom`) VALUES
(NULL, 'nancy', '48.6833', '6.222222', "30", '60', '16'),
(NULL, 'paris', '48.866667', '2.333333', "50", '60', '18');


INSERT INTO `partie` (`id`, `token`, `nb_photos`, `status`, `score`, `joueur`, `difficulte`, `created_at`, `updated_at`, `id_serie`) VALUES
(NULL, 'zerdtvbhu', '10', '2', '20', 'Jeandudu', '0.8', '2018-02-08 18:30:20', '2018-02-08 18:30:21', 1);


INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `mail`, `pseudo`, `password`) VALUES
(NULL, 'Jean', 'Dupont', 'jean.dupont@gmail.com', "Jeandudu", '$2y$10$D1aPiI7aV/kpnKD...dVneDciZNYPCRQIfeVbK8gw3LXNp4.y.2H6'),
(NULL, 'Michel', 'Evrard', 'michel.evrard@gmail.com', "MichelEv", '$2y$10$hSbGNuZkCs7EwgjGqJof8.8GqIQewgcsozPhJOZw3MTbnIeb.a4hi');


INSERT INTO `photo` (`id`, `nom`, `description`, `url`, `latitude`, `longitude`, `id_serie`) VALUES
(NULL, 'parc de la Pepiniere', 'Parc de la pépinière avec une aire de jeu', 'http://image-photos.linternaute.com/image_photo/450/2976037860/571681.jpg', "48.698249", '6.184871', 1),
(NULL, 'cathedrale NDA', 'Cathédrale Notre-Dame-de-lAnnonciation de Nancy ', 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/Nancy_Cathedral_BW_2015-07-18_16-31-28.jpg/280px-Nancy_Cathedral_BW_2015-07-18_16-31-28.jpg', "48.691177", '6.186078', 1),
(NULL, 'musee de Lorrain', 'Musée lorrain, est le musée historique de la région Lorraine, lun des trois grands musées de la ville de Nancy', 'https://www.musee-lorrain.nancy.fr/fichier/media_image/7659/image_src_6.jpg', "48.697281", '6.179390', 1),
(NULL, 'place De La Carrière', 'La place de la Carrière est une place de la ville-vieille de Nancy, édifiée à partir du XVIème siècle', 'http://www.armoiriesdeparis.fr/Pages/Pages_D54/un.jpg', "48.695571", '6.182138', 1),    
(NULL, 'porte De La Craffe', 'La porte de la Craffe est une porte de Nancy, imposant vestige des fortifications médiévales, érigée au XIVème siècle au nord de la ville-vieille', 'http://www.nancy-tourisme.info/wp-content/uploads/2013/08/Porte-de-la-Craffe.jpg', "48.698867", '6.177770', 1),
(NULL, 'arc Here', 'L arc Héré, également nommée porte Héré, est un édifice sis au sein de la commune de Nancy.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ef/Arc_H%C3%A9r%C3%A9%2C_Place_Stanislas%2C_Nancy.jpg/260px-Arc_H%C3%A9r%C3%A9%2C_Place_Stanislas%2C_Nancy.jpg', "48.694415", '6.182695', 1),
(NULL, 'villa Majorelle', 'La villa Majorelle est une maison de maître, construite de 1901 à 1902, située à Nancy, dans le style École de Nancy.', 'http://www.culture.gouv.fr/culture/inventai/itiinv/archixx/imgs/p42-01im.jpg', "48.685484", '6.163885', 1),
(NULL, 'eglise Saint-Georges', 'Léglise Saint-Georges est une église de culte catholique érigée au XIXème siècle à Nancy', 'https://asset-premium.keepeek.com/medias/domain37/media264/39688-fhejy230ou-whr.jpg', "48.695895", '6.194775', 1),
(NULL, 'palais Du Gouvernement', 'Le palais du Gouvernement et son jardin', 'http://www.stanislasurbietorbi.com/itineraires/PHOTOS%20itineraire/photos-1-itineraire/horizontal-reduit/arriere-palais-gourverneur.jpg', "48.697475", '6.180562', 1),
(NULL, 'ancien Site Alstom', 'Musée à nancy', 'http://cdn-s-www.estrepublicain.fr/images/66C26BF6-510A-4341-8849-20CE82BB73A0/ERV_04/alstom-nancy-118-ans-d-histoire-1489673449.jpg', "48.702417", '6.187786', 1),
(NULL, 'parc Blondlot', 'Le parc Blondlot est un jardin public du centre-ville de Nancy', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Nancy_%2854%29_-_Parc_Blondlot.JPG/280px-Nancy_%2854%29_-_Parc_Blondlot.jpg', "48.691903", '6.173572', 1),
(NULL, 'porte Desilles', 'La porte Désilles est un arc de triomphe situé à Nancy, à louest de la vieille-ville et à lextrémité nord du Cours Léopold', 'https://upload.wikimedia.org/wikipedia/commons/c/ce/Porte_D%C3%A9silles%2C_Nancy%2C_Lorraine%2C_France_-_panoramio.jpg', "48.697957", '6.174196', 1),
(NULL, 'MAN', 'Le muséum-aquarium de Nancy, souvent abrégé en MAN, est un établissement patrimonial de culture scientifique', 'http://www.grandnancy.eu/fileadmin/fichiers/web/MMM/MAN/8.jpg', "48.694918", '6.188237', 1),
(NULL, 'musee Histoire du Fer', 'Le musée de lhistoire du fer est un établissement de culture scientifique', 'https://www.nancy.fr/fileadmin/images/Culturelle/Musees_et_visites/Les_6_musees/Musees_Grand_Nancy/2011-07-musee-histoire-du-fer-2-_c_-grand-nancy.jpg', "48.666459", '6.208690', 1),
(NULL, 'basilique Saint-Epvre', 'La Basilique Saint-Epvre de Nancy est une basilique de style néogothique construite au XIXème siècle en pierre dEuville', 'https://c1.staticflickr.com/3/2397/4506992127_e1942058f4_b.jpg', "48.695998", '6.179931', 1),
(NULL, 'foret de Haye', 'La forêt de Haye est un vaste massif forestier, denviron 10 000 hectares, dont 6 500 de forêt domaniale', 'http://www.nancy-tourisme.fr/fileadmin/nancy_tourisme/documents/thematiques/au_vert/parc-de-brabois.jpg', "48.684339", '6.077335', 1),
(NULL, 'place de Lalliance', 'La place de lalliance au centre ville de nancy', 'http://mw2.google.com/mw-panoramio/photos/medium/760263.jpg', "48.693773", '6.186259', 1),
(NULL, 'musee des Beaux Arts', 'Le musée des beaux-arts de Nancy, créé le 16 mai 1793, est lun des plus anciens musées de France', 'http://upload.wikimedia.org/wikipedia/commons/5/59/Nancy_-_Musee_des_Beaux_Arts.jpg', "48.693434", '6.182121', 1),
(NULL, 'porte Sainte-Catherine', 'La porte Sainte-Catherine est une porte de Nancy, érigée au XVIIIème siècle.', 'https://media-cdn.tripadvisor.com/media/photo-s/0d/64/fc/63/porte-sainte-catherine.jpg', "48.695595", '6.189907', 1),
(NULL, 'chateaux Montaigu', 'Le château de Montaigu est un château situé sur la commune française de Laneuveville-devant-Nancy près de Nancy.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/F54_Jarville_ch%C3%A2teau-de-Montaigu.JPG/280px-F54_Jarville_ch%C3%A2teau-de-Montaigu.jpg', "48.664636", '6.209929', 1);

INSERT INTO `photo` (`id`, `nom`, `description`, `url`, `latitude`, `longitude`, `id_serie`) VALUES
(NULL, 'tourEiffel', 'La tour Eiffel est une tour de fer puddlé de 324 mètres de hauteur située à Paris', 'https://www.parisinfo.com/var/otcp/sites/images/media/1.-photos/02.-sites-culturels-630-x-405/tour-eiffel-trocadero-630x405-c-thinkstock/37221-1-fre-FR/Tour-Eiffel-Trocadero-630x405-C-Thinkstock.jpg', "48.858262", '2.294622', 2),
(NULL, 'museeDuLouvre', 'Le musée du Louvre est le plus grand musée dart et dantiquités au monde, situé au centre de Paris dans le palais du Louvre', 'https://fr.petitsfrenchies.com/wp-content/uploads/2017/01/museedulouvre-1460x650.jpg', "48.860555", '2.337605', 2),
(NULL, 'CathédraleNDP', 'La cathédrale Notre-Dame de Paris, en forme courte Notre-Dame, est la cathédrale de l’archidiocèse de Paris', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c0/Notre_Dame_de_Paris_DSC_0846w.jpg/280px-Notre_Dame_de_Paris_DSC_0846w.jpg', "48.852874", '2.350155', 2),
(NULL, 'basiliqueSacreCoeur', 'La basilique du Sacré-Cœur de Montmartre, dite du Vœu national, située au sommet de la butte Montmartre', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Sacre-Coeur_May_10%2C_1960.jpg/280px-Sacre-Coeur_May_10%2C_1960.jpg', "48.886634", '2.343083', 2),
(NULL, 'jardindesTuileries', 'Le jardin des Tuileries, parfois appelé jardins des Tuileries au pluriel, est un parc parisien du 1er arrondissement créé au XVIème', 'https://images.lesechos.fr/archives/2017/LesEchos/22491/ECH22491071_1.jpg', "48.863239", '2.327478', 2),
(NULL, 'placeConcorde', 'La place de la Concorde, avec 8,64 hectares, est la plus grande place de Paris.', 'https://media1.britannica.com/eb-media/15/178015-004-9E86D314.jpg', "48.865450", '2.321118', 2),
(NULL, 'jardinduLuxembourg', 'Le jardin du Luxembourg est un jardin ouvert au public, situé dans le 6ème arrondissement de Paris.', 'http://www.hotelnovanox.com/wp-content/uploads/2015/11/jardin-luxembourg-paris.jpg', "48.865450", '2.321118', 2),
(NULL, 'centrePompidou', 'Le Centre national d’art et de culture Georges-Pompidou – communément appelé « Centre Georges-Pompidou', 'http://webradio.univ-paris13.fr/wp-content/uploads/2013/04/centre-pompidou-1.jpg', "48.860620", '2.352284', 2),
(NULL, 'avneueChampsÉlysées', 'L’avenue des Champs-Élysées est une grande et célèbre voie de Paris. ', 'http://cityguide.paris-is-beautiful.com/wp-content/uploads/2013/10/984-AVENUE-CHAMPS-ELYSEES.jpg', "48.871674", '2.301717', 2),
(NULL, 'champDeMars', 'Le Champ-de-Mars est un vaste jardin public, entièrement ouvert et situé à Paris dans le 7ème arrondissement', 'https://igx.4sqi.net/img/general/200x200/52197741_kwCQJyB29A0dXx4oiF0ktji7E9pnW73f-21Jbc3ukeQ.jpg', "48.855450", '2.298706', 2),
(NULL, 'tourMontparnasse', 'La tour Montparnasse, également appelée tour Maine-Montparnasse, est le plus haut gratte-ciel de Paris intra-muros', 'https://www.amc-archi.com/mediatheque/1/9/4/000025491/la-tour-montparnasse-paris.jpg', "48.842128", '2.321965', 2),
(NULL, 'pantheon', 'Le Panthéon est un monument de style néo-classique situé dans le 5ème arrondissement de Paris', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/80/Pantheon_of_Paris_007.JPG/260px-Pantheon_of_Paris_007.jpg', "48.846189", '2.346429', 2),
(NULL, 'grandPalais', 'Le Grand Palais est un monument parisien situé en bordure des Champs-Élysées,', 'https://media-cdn.tripadvisor.com/media/photo-o/08/03/3f/99/grand-palais.jpg', "48.866168", '2.312595', 2),
(NULL, 'hotelInvalides', 'L’hôtel des Invalides est un monument parisien dont la construction fut ordonnée par Louis XIV', 'http://paris1900.lartnouveau.com/paris07/invalides/acceuil/1inval_ouest1.jpg', "48.855550", '2.313341', 2),
(NULL, 'palaisCite', 'Palais gothique au bord de la Seine et prison de la Révolution avec lancienne cellule de Marie-Antoinette.', 'https://files.offi.fr/lieu/3665/images/600/1260205252308.jpg', "48.856001 ", '2.345504', 2),
(NULL, 'ileCite', 'L’île de la Cité est une île située sur la Seine, en plein cœur de Paris. ', 'http://france.jeditoo.com/IleDeFrance/Paris/4eme/ile-cite/vue-aerienne-ile-de-la-cite.jpg', "48.854936", '2.347256', 2),
(NULL, 'museeRodin', 'Le musée Rodin est un musée assurant depuis 1919 la conservation et la diffusion de l’œuvre d’Auguste Rodin.', 'http://m5.22slides.com/michaeldaks/rodin6221webi-1385471.jpg', "48.855322", '2.315882', 2),
(NULL, 'museeOrangerie ', 'Le musée de l’Orangerie est un musée de peintures impressionnistes et postimpressionnistes situé dans le Jardin des Tuileries', 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Mus%C3%A9e_de_l%E2%80%99Orangerie_exterior.JPG/1200px-Mus%C3%A9e_de_l%E2%80%99Orangerie_exterior.jpg', "48.863915", '2.323413', 2),
(NULL, 'boisBoulogne', 'Le bois de Boulogne est une étendue boisée, située dans le 16ème arrondissement de Paris. ', 'https://cdt40.media.tourinsoft.eu/upload/Bois-de-Boulogne-Dax.jpg', "48.862216", '2.249109', 2);
