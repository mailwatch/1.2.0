<?php

/*
 * MailWatch for MailScanner
 * Copyright (C) 2003-2011  Steve Freegard (steve@freegard.name)
 * Copyright (C) 2011  Garrod Alwood (garrod.alwood@lorodoes.com)
 * Copyright (C) 2014-2016  MailWatch Team (https://github.com/orgs/mailwatch/teams/team-stable)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * In addition, as a special exception, the copyright holder gives permission to link the code of this program with
 * those files in the PEAR library that are licensed under the PHP License (or with modified versions of those files
 * that use the same license as those files), and distribute linked combinations including the two.
 * You must obey the GNU General Public License in all respects for all of the code used other than those files in the
 * PEAR library that are licensed under the PHP License. If you modify this program, you may extend this exception to
 * your version of the program, but you are not obligated to do so.
 * If you do not wish to do so, delete this exception statement from your version.
 *
 * As a special exception, you have permission to link this program with the JpGraph library and distribute executables,
 * as long as you follow the requirements of the GNU GPL in regard to all of the software in the executable aside from
 * JpGraph.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/* languages/fr.php */
/* v0.2.9 */

return array(
    // 01-login.php
    'username' => 'Utilisateur :',
    'password' => 'Mot de Passe :',
    'mwloginpage01' => 'MailWatch Login Page',
    'mwlogin01' => 'Connexion&nbsp;à&nbsp;MailWatch',
    'badup01' => 'Mauvais Utilisateur ou Mot de Passe',
    'emptypassword01' => 'Le Mot de Passe ne peut pas être vide',
    'errorund01' => 'Une rreur inconnue c\'est produite',
    'login01' => 'Connexion',

    // 03-functions.php
    'jumpmessage03' => 'Aller au message :',
    'cuser03' => 'Utilisateur',
    'cst03' => 'Heure Système',
    'colorcodes03' => 'Codes couleur',
    'badcontentinfected03' => 'Contenu nocif/infecté',
    'whitelisted03' => 'Liste Blanche',
    'blacklisted03' => 'Liste Noire',
    'notverified03' => 'Non vérifié',
    'clean03' => 'Légitime',
    'status03' => 'Statut',
    'mailscanner03' => 'Mailscanner :',
    'none03' => 'Aucun',
    'yes03' => 'OUI',
    'no03' => 'NON',
    'message03' => 'Message',
    'tries03' => 'Essais',
    'last03' => 'Dernier',
    'loadaverage03' => 'Charge Moyenne :',
    'mailqueue03' => 'Files d\'attente de courrier',
    'inbound03' => 'En entrée :',
    'outbound03' => 'En partance :',
    'topvirus03' => 'Top Virus :',
    'freedspace03' => 'Espace disque libre',
    'todaystotals03' => 'Total aujourd\'hui',
    'processed03' => 'Traité :',
    'cleans03' => 'Légitime :',
    'viruses03' => 'Virus :',
    'blockedfiles03' => 'Fichier(s) bloqué(s) :',
    'others03' => 'Autre :',
    'spam03' => 'Spam :',
    'spam103' => 'Spam',
    'hscospam03' => 'Spam à haut score :',
    'hscomcp03' => 'MCP à haut score :',
    'recentmessages03' => 'Messages récent',
    'lists03' => 'Listes Noire et Blanche',
    'quarantine03' => 'Quarantaine',
    'datetime03' => 'Date/Heure',
    'from03' => 'De',
    'to03' => 'À',
    'size03' => 'Taille',
    'subject03' => 'Sujet',
    'sascore03' => 'Points SA',
    'mcpscore03' => 'Points MCP',
    'found03' => 'trouvé',
    'highspam03' => 'Spam Haut',
    'mcp03' => 'MCP',
    'highmcp03' => 'MCP Haut',
    'reports03' => 'Recherche et Rapports',
    'toolslinks03' => 'Outils et Liens',
    'softwareversions03' => 'Version des logiciels',
    'documentation03' => 'Documentation',
    'logout03' => 'Déconnexion',
    'pggen03' => 'Page générée en',
    'seconds03' => 'secondes',
    'disppage03' => 'Affichage de la page',
    'of03' => 'de',
    'records03' => 'Enregistrements de',
    'to0203' => 'à',
    'score03' => 'Points',
    'matrule03' => 'Règle associée',
    'description03' => 'Description',
    'footer03' => 'MailWatch pour MailScanner v',
    'mailwatchtitle03' => 'MailWatch pour Mailscanner',
    'php703' => 'MailWatch a besoin du pilote MySQL pour fonctionner. Dans PHP7 ce pilote qui est devenu obsoléte',
    'radiospam203' => 'S',
    'radioham03' => 'D',
    'radioforget03' => 'O',
    'radiorelease03' => 'L',
    'clear03' => 'Effacer</a> la sélection',
    'spam203' => 'S</b> = Spam',
    'ham03' => 'D</b> = Déclarer comme légitime',
    'forget03' => 'O</b> = Oublier',
    'release03' => 'L</b> = Libérer',
    'learn03' => 'Apprendre',
    'ops03' => 'Options',
    'or03' => 'ou',
    'mwfilterreport03' => 'Rapport pour MailWatch :',
    'mwforms03' => 'MailWatch pour Mailscanner - ',
    'dieerror03' => 'Erreur :',
    'dievirus03' => 'Vous exécutez MailWatch en mode distribué ce qui entraine que MailWatch ne peut pas lire vos fichiers de configuration MailScanner pour vérifier votre scanner de virus primaire. Vous devez éditer le fichier functions.php et manuellement définir la contante VIRUS_REGEX en fonction de votre logiciel de scan de virus.',
    'diescanner03' => 'Impossible de séelctionner une expression régulière pour votre scanner de virus primaire ($scanner). Regardez les exemples dans functions.php pour en créer un nouveau.',
    'diedbconn103' => 'Impossible de se connecter à la base de données :',
    'diedbconn203' => 'Impossible de sélectionner la base de données :',
    'diedbquery03' => 'Erreur lors de l\'exécution de la requête :',
    'dieruleset03' => 'Impossible d\'ouvrir le fichier de règle',
    'dienomsconf03' => 'Impossible d\'ouvrir le fichier de configuration MailScanner',
    'dienoconfigval103' => 'Impossible de trouver la variable de configuration :',
    'dienoconfigval203' => 'dans',
    'ldpaauth103' => 'Impossible de se connecter à',
    'ldpaauth203' => 'Impossible de rechercher',
    'ldpaauth303' => 'Impossible d\'obtenir les entrées',
    'ldapgetconfvar103' => 'Erreur : impossible de se connecter à l\'annuaire LDAP sur :',
    'ldapgetconfvar203' => 'Erreur : impossible de se lier à l\'annuaire LDAP',
    'ldapgetconfvar303' => 'Erreur : impossible de trouver la variable de configuration',
    'ldapgetconfvar403' => 'dans l\'annuaire LDAP.',
    'dietranslateetoi03' => 'Impossible d\'ouvrir le fichier ConfigDefs de MailScanner :',
    'diequarantine103' => 'ID du message',
    'diequarantine203' => 'non trouvé.',
    'diequarantine303' => 'Impossible d\'ouvrir le répertoire de quarantaine :',
    'diereadruleset03' => 'Impossible d\'ouvrir le fichier de règle MailScanner',

    // 04-detail.php
    'receivedon04' => 'Reçu le :',
    'receivedby04' => 'Reçu par :',
    'receivedfrom04' => 'Reçu de :',
    'receivedvia04' => 'Reçu via :',
    'msgheaders04' => 'En-tête :',
    'from04' => 'De :',
    'to04' => 'À :',
    'size04' => 'Taille :',
    'subject04' => 'Sujet :',
    'hdrantivirus04' => 'Anti-Virus/Protection contre les fichiers nocif',
    'blkfile04' => 'Fichier bloqué :',
    'otherinfec04' => 'Autre infection :',
    'hscospam04' => 'Spam à haut score :',
    'listedrbl04' => 'Listé en RBL :',
    'spamwl04' => 'Spam en Liste Blanche :',
    'spambl04' => 'Spam en Liste Noire : ',
    'saautolearn04' => 'Auto aprentissage SpamAssassin :',
    'sascore04' => 'Points SpamAssassin :',
    'spamrep04' => 'Rapport de Spam :',
    'hdrmcp04' => 'Protection des contenus (MCP)',
    'highscomcp04' => 'MCP à Point Haut :',
    'mcpwl04' => 'MCP en Liste Blanche :',
    'mcpbl04' => 'MCP en Liste Noire :',
    'mcpscore04' => 'Points MCP :',
    'mcprep04' => 'Rapport MCP :',
    'ipaddress04' => 'Adresse IP',
    'country04' => 'Pays',
    'all04' => 'Tout',
    'addwl04' => 'Ajouter à la Liste Blanche',
    'addbl04' => 'Ajouter à la Liste Noire',
    'release04' => 'Libérer',
    'delete04' => 'Supprimer',
    'salearn04' => 'Apprentissage SA',
    'file04' => 'Fichier',
    'type04' => 'Type',
    'path04' => 'Chemin',
    'dang04' => 'Nocif ',
    'altrecip04' => 'Destinataire alternatif',
    'submit04' => 'Soumettre',
    'actions04' => 'Action(s)',
    'quarcmdres04' => 'Résultat des commandes de quarantaine',
    'resultmsg04' => 'Résultat du message',
    'id04' => 'ID :',
    'virus04' => 'Virus :',
    'spam04' => 'Spam :',
    'spamassassinspam04' => 'Spam SpamAssassin :',
    'quarantine04' => 'Quarantaine',
    'messdetail04' => 'Détail du message',
    'dieid04' => 'ID du message',
    'dienotfound04' => 'non trouvé !',
    'asham04' => 'Comme Légitime',
    'aspam04' => 'Comme Spam',
    'forget04' => 'Oublier',
    'spamreport04' => 'Comme Spam+Etat',
    'spamrevoke04' => 'Comme Légitime+Retirez',

    // 05-status.php
    'recentmsg05' => 'Messages récents',
    'last05' => 'Derniers',
    'messages05' => 'messages',
    'refevery05' => 'La page se rafraîchit toutes les',
    'seconds05' => 'secondes',

    // 06 - viewmail.php
    'msgviewer06' => 'Visualisation d\'un message',
    'releasemsg06' => 'Libérer ce message',
    'deletemsg06' => 'Supprimer ce message',
    'actions06' => 'Actions :',
    'date06' => 'Date :',
    'from06' => 'De :',
    'to06' => 'À :',
    'subject06' => 'Sujet :',
    'nomessid06' => 'Aucun ID de message saisie',
    'mess06' => 'Message',
    'notfound06' => 'non trouvé',
    'error06' => 'Erreur :',
    'errornfd06' => 'Erreur : fichier non trouvé',
    'mymetype06' => 'Type MIME :',

    // 07-lists.php
    'addwlbl07' => 'Ajouter à la Liste Noire/Blanche',
    'from07' => 'De',
    'to07' => 'À',
    'list07' => 'Liste',
    'action07' => 'Action',
    'wl07' => 'Liste Blanche',
    'bl07' => 'Liste Noire',
    'reset07' => 'Réinitialiser',
    'add07' => 'Ajouter',
    'delete07' => 'Supprimer',
    'wblists07' => 'Listes Noire et Blanche',

    // 08-quarantine.php
    'folder08' => 'Dossier de quarantaine :',
    'folder_0208' => 'Dossier :',
    'items08' => 'éléments',
    'qviewer08' => 'Visualisation de la quarantaine',
    'dienodir08' => 'Aucun répertoire de quarantaine trouvé',

    // 09-filter.inc.php
    'activefilters09' => 'Filtre actif',
    'none09' => 'Aucun',
    'addfilter09' => 'Ajouter un filtre',
    'loadsavef09' => 'Ouvrir/Enregistrer un filtre',
    'tosetdate09' => 'Entrer la date sous le format AAAA-MM-JJ',
    'oldrecord09' => 'Enregistrement le plus vieux :',
    'newrecord09' => 'Enregistrement le plus jeune :',
    'messagecount09' => 'Nombre de message :',
    'stats09' => 'Statistiques (Filtrées)',
    'add09' => 'Ajouter',
    'load09' => 'Charger',
    'save09' => 'Enregistrer',
    'delete09' => 'Effacer',
    'none09' => 'Aucun',
    'equal09' => 'est égal à',
    'notequal09' => 'n\'est pas égal à',
    'greater09' => 'is greater than',
    'greaterequal09' => 'is greater than or equal to',
    'less09' => 'is less than',
    'lessequal09' => 'is less than or equal to',
    'like09' => 'contains',
    'notlike09' => 'does not contain',
    'regexp09' => 'matches the regular expression',
    'notregexp09' => 'does not match the regular expression',
    'isnull09' => 'is null',
    'isnotnull09' => 'is not null',
    'date09' => 'Date',
    'headers09' => 'Headers',
    'id09' => 'Message ID',
    'size09' => 'Size (bytes)',
    'fromaddress09' => 'From',
    'fromdomain09' => 'From Domain',
    'toaddress09' => 'To',
    'todomain09' => 'To Domain',
    'subject09' => 'Subject',
    'clientip09' => 'Received from (IP Address)',
    'isspam09' => 'is Spam (>0 = TRUE)',
    'ishighspam09' => 'is High Scoring Spam (>0 = TRUE)',
    'issaspam09' => 'is Spam according to SpamAssassin (>0 = TRUE)',
    'isrblspam09' => 'is Listed in one or more RBL\'s (>0 = TRUE)',
    'spamwhitelisted09' => 'is Whitelisted (>0 = TRUE)',
    'spamblacklisted09' => 'is Blacklisted (>0 = TRUE)',
    'sascore09' => 'SpamAssassin Score',
    'spamreport09' => 'Spam Report',
    'ismcp09' => 'is MCP (>0 = TRUE)',
    'ishighmcp09' => 'is High Scoring MCP (>0 = TRUE)',
    'issamcp09' => 'is MCP according to SpamAssassin (>0 = TRUE)',
    'mcpwhitelisted09' => 'is MCP Whitelisted (>0 = TRUE)',
    'mcpblacklisted09' => 'is MCP Blacklisted (>0 = TRUE)',
    'mcpscore09' => 'MCP Score',
    'mcpreport09' => 'MCP Report',
    'virusinfected09' => 'contained a Virus (>0 = TRUE)',
    'nameinfected09' => 'contained an Unacceptable Attachment (>0 = TRUE)',
    'otherinfected09' => 'contained other infections (>0 = TRUE)',
    'report09' => 'Virus Report',
    'hostname09' => 'MailScanner Hostname',

    // 10-other.php
    'tools10' => 'Outils et Liens',
    'usermgnt10' => 'Gestion des utilisateurs',
    'avsophosstatus10' => 'Statut Sophos',
    'avfsecurestatus10' => 'Statut F-Secure',
    'avclamavstatus10' => 'Statut ClamAV',
    'avmcafeestatus10' => 'Statut McAfee',
    'avfprotstatus10' => 'Statut F-Prot',
    'mysqldatabasestatus10' => 'Statut de la base de données MySQL',
    'viewconfms10' => 'Afficher la configuration de MailScanner',
    'editmsrules10' => 'Editer les filtres MailScanner',
    'spamassassinbayesdatabaseinfo10' => 'Information sur la base de données Bayes SpamAssassin',
    'updatesadesc10' => 'Mettre à jour les descriptions des règles SpamAssassin',
    'updatemcpdesc10' => 'Mettre à jour les descriptions des règles MCP',
    'updategeoip10' => 'Mettre à jour la base GeoIP',
    'links10' => 'Liens',

    // 11-sf_versions.php
    'softver11' => 'Version des logiciels',
    'nodbdown11' => 'Aucune base de données téléchargée',
    'version11' => 'version :',

    // 12-user_manager.php
    'usermgnt12' => 'Gestion des utilisateurs',
    'username12' => 'Nom d\'utilisateur',
    'fullname12' => 'Nom complet',
    'type12' => 'Type',
    'spamcheck12' => 'Vérifier les Spam',
    'spamscore12' => 'Points de Spam',
    'spamhscore12' => 'Points de Spam Haut',
    'action12' => 'Actions',
    'edit12' => 'Editer',
    'delete12' => 'Supprimer',
    'filters12' => 'Filtres',
    'newuser12' => 'Créer un nouveau compte utilisateur',
    'forallusers12' => 'Pour tous les utilisateurs autre que les administrateurs, vous devez utiliser une adresse E-Mail pour le nom d\'utilisateur.',
    'username0212' => 'Nom d\'utilisateur :',
    'name12' => 'Nom :',
    'password12' => 'Mot de Passe :',
    'usertype12' => 'Type d\'utilisateur :',
    'user12' => 'Utilisateur',
    'domainadmin12' => 'Administrateur de Domaine',
    'admin12' => 'Administrateur',
    'quarrep12' => 'Rapport de Quarantaine :',
    'senddaily12' => 'Envoyer un Rapport de Spam ?',
    'quarreprec12' => 'Destinataire du Rapport de Spam :',
    'overrec12' => 'Remplacer le destinataire par défaut <BR>(Utilise le nom d\'utilisateur par défaut si vide)',
    'scanforspam12' => 'Scan des Spam :',
    'scanforspam212' => 'Scan des E-Mail pour les Spam ?',
    'pontspam12' => 'Points de Spam :',
    'hpontspam12' => 'Points de Spam Haut :',
    'usedefault12' => 'Utiliser les réglages par défaut',
    'action_0212' => 'Action :',
    'reset12' => 'Réinitialiser',
    'areusuredel12' => 'Voulez-vous vraiment effacer l\'utilisateur',
    'errorpass12' => 'Le Mot de Passe de correspond pas.',
    'edituser12' => 'Editer l\'utilisateur',
    'create12' => 'Créer',
    'userregex12' => 'Utilisateur (Regexp)',
    'update12' => 'Mettre à jour',
    'userfilter12' => 'Filtres d\'utilsateur pour',
    'filter12' => 'Filtre',
    'add12' => 'Ajouter',
    'active12' => 'Etat',
    'yes12' => 'Oui',
    'no12' => 'Non',
    'questionmark12' => ' ?',
    'toggle12' => 'Activer/Désactiver',
    'sure12' => 'Êtes-vous sûr ?',
    'unknowtype12' => 'Type Inconnu',
    'yesshort12' => 'O',
    'noshort12' => 'N',

    // 13-sa_rules_update.php
    'input13' => 'Démarrer',
    'updatesadesc13' => 'Mettre à jour les descriptions des règles SpamAssassin',
    'message113' => 'Cet utilitaire est utilisé pour mettre à jour la base de données SQL avec une description des règles de SpamAssassin qui sont affichés sur l\'écran Message Détail mise à jour.',
    'message213' => 'Cet utilitaire doit généralement être exécuté après une mise à jour SpamAssassin, mais il est possible de le lancer à tout moment car il ne remplace que les valeurs existantes et insère seulement de nouvelles valeurs dans le tableau (donc en préservant les descriptions de règles potentiellement obsolètes ou supprimés).',
    'saruldesupdate13' => 'Mise à jour des descriptions des règles SpamAssassin',

    // 14-reports.php
    'messlisting14' => 'Listing des messages',
    'messop14' => 'Manipulation sur les messages',
    'messdate14' => 'Total des messages par date',
    'topmailrelay14' => 'Top des relais de messagerie',
    'topvirus14' => 'Top Virus',
    'virusrepor14' => 'Rapport sur les Virus',
    'topsendersqt14' => 'Top des expéditeurs par quantité',
    'topsendersvol14' => 'Top des expéditeurs par volume',
    'toprecipqt14' => 'Top des destinataires par quantité',
    'toprecipvol14' => 'Top des destinataires par volume',
    'topsendersdomqt14' => 'Top des domaines d\'expédition par quantité',
    'topsendersdomvol14' => 'Top des domaines d\'expédition par volume',
    'toprecipdomqt14' => 'Top des domaines de destination par quantité',
    'toprecipdomvol14' => 'Top des domaines de destination par volume',
    'assassinscoredist14' => 'Distribution SpamAssassin par point',
    'assassinrulhit14' => 'Distribution SpamAssassin par règle',
    'auditlog14' => 'Log de l\'Audit',
    'mrtgreport14' => 'Rapport de message MRTG',
    'mcpscoredist14' => 'Score MCP par point',
    'mcprulehit14' => 'Score MCP par règle',
    'reports14' => 'Rapports',

    // 15-geoip_update.php
    'input15' => 'Démarrer',
    'updategeoip15' => 'Mettre à jour les bases GeoIP',
    'message115' => 'Cet utilitaire est utilisé pour télécharger les fichiers de la base de données GeoIP (qui sont mis à jour le premier mardi de chaque mois) à partir de',
    'message215' => 'qui est utilisé pour travailler sur le pays d\'origine pour une adresse IP donnée et est affiché sur la page Message Détail.',
    'downfile15' => 'Téléchargement du fichier en cours, veuillez patienter...',
    'geoipv415' => 'Fichier de données GeoIP IPv4',
    'geoipv615' => 'Fichier de données GeoIP IPv6',
    'downok15' => ': téléchargement réussi',
    'downbad15' => 'Une erreur c\'est produite pendant le téléchargement',
    'downokunpack15' => 'Téléchargement complet, extraction des fichiers...',
    'message315' => 'Impossible de télécharger le fichier de données GeoIP (curl et fsockopen essayés).',
    'message415' => 'Veuillez installer le module PHP cURL (préféré) ou activer fsockopen dans votre fichier php.ini',
    'unpackok15' => ': décompactage réussi',
    'extractnotok15' => 'Impossible d\'extraire',
    'extractok15' => 'extraction réussie',
    'message515' => 'Impossible d\'extraire le fichier de données GeoIP.',
    'message615' => 'Activez le module PHP Zlib dans votre configuration PHP ou installez le binaire gunzip.',
    'processok' => 'Processus terminé !',
    'norread15' => 'Impossible de lire ou d\'écrire sur le',
    'message715' => 'Les fichiers existent toujours pour une raison inconnue.',
    'message815' => 'Effacez-les à la main à partir de',
    'directory15' => 'répertoire',
    'geoipupdate15' => 'Mise à jour des bases GeoIP',
    'dieproxy15' => 'Proxy type should be either "HTTP" or "SOCKS5", check your configuration file',

    // 16-rep_message_listing.php
    'messlisting16' => 'Listing des messages',

    // 17-rep_message_ops.php
    'messageops17' => 'Manipulation sur les Messages',
    'messagelisting17' => 'Listing des Messages',

    // 18-bayes_info.php
    'spamassassinbayesdatabaseinfo18' => 'Information sur la base SpamAssassin Bayes',

    // 19-clamav_status.php
    'avclamavstatus19' => 'Statut ClamAV',

    // 20-docs.php
    'doc20' => 'Documentation',
    'message20' => 'Cette page ne peut être accédée qu\'en mode autentifié. Vous poouvez y mettre un lien vers la documentation interne de votre site pour que les utilisateurs puissent y avoir accès.',

    // 21-do_message_ops.php
    'opresult21' => 'Résultat des opérations',

    // 22-f-prot_status.php
    'fprotstatus22' => 'Statut F-Prot',

    // 23-f-secure_status.php
    'fsecurestatus23' => 'Statut F-Secure',

    // 24-mailq.php
    'mqviewer24' => 'Mail Queue Viewer',
    'diemq24' => 'Aucune file d\'attente définie',

    // 25-mcafee_status.php
    'mcafeestatus25' => 'Statut McAfee',

    // 26-mcp_rules_update.php
    'mcpruledesc26' => 'Mise à jour des descriptions des règles MCP',

    // 27-msconfig.php
    'config27' => 'Configuration',

    // 28-ms_lint.php
    'mailscannerlint28' => 'MailScanner Lint',
    'diepipe28' => 'Impossible d\'ouvrir le conduit',

    // 29-msre_index.php
    'rulesetedit29' => 'Editeur de règle',

    // 30-msrule.php
    'rules30' => 'Règles',

    // 31-mysql_status.php
    'mysqlstatus31' => 'Statut MySQL',

    // 32-postfixmailq.php
    'mqviewer32' => 'Visualisateur de file d\'attente de courrier',
    'mqcombined32' => 'File d\'attente combinée de courrier (d\'arrivée et en partance)',

    // 33-rep_audit_log.php
    'auditlog33' => 'Log de l\'Audit',
    'datetime33' => 'Date/Heure',
    'user33' => 'Utilisateur',
    'ipaddress33' => 'Adresse IP',
    'action33' => 'Action',

    // 34-rep_mcp_rule_hits.php
    'mcprulehits34' => 'Score MCP par point',
    'rule34' => 'Règle',
    'des34' => 'Description',
    'total34' => 'Total',
    'clean34' => 'Légitime',
    'mcp34' => 'MCP',

    // 35-rep_mcp_score_dist.php
    'mcpscoredist35' => 'Score MCP par règle',
    'die35' => 'Erreur : il est nécessaire d\'avoir deux enregistrements ou plus dans la base de données',
    'scorerounded35' => 'Points (arondis)',
    'nbmessages35' => 'Nb de message',
    'score35' => 'Distribution',
    'count35' => 'Total',

    // 36-rep_mrtg_style.php
    'mrtgstyle36' => 'Rapport de message MRTG',
    'die36' => 'Erreur : il est nécessaire d\'avoir deux enregistrements ou plus dans la base de données',

    // 37-rep_sa_rule_hits.php
    'sarulehits37' => 'Distribution de SpamAssassin par règle',
    'rule37' => 'Règle',
    'desc37' => 'Description',
    'score37' => 'Points',
    'total37' => 'Total',
    'ham37' => 'Légitime',
    'spam37' => 'Spam',

    // 38-rep_sa_score_dist.php
    'sascoredist38' => 'Distribution SpamAssassin par point',
    'scorerounded38' => 'Points (arondis)',
    'nbmessage38' => 'Nb de message',
    'score38' => 'Points',
    'count38' => 'Nombre',
    'die38' => 'Erreur : il est nécessaire d\'avoir deux enregistrements ou plus dans la base de données',

    // 39-rep_top_mail_relays.php
    'topmailrelays39' => 'Top des relais de messagerie',
    'top10mailrelays39' => 'Top 10 des relais de messagerie',
    'hostname39' => 'Nom de serveur',
    'ipaddresses39' => 'Adresse IP',
    'country39' => 'Pays',
    'messages39' => 'Messages',
    'viruses39' => 'Virus',
    'spam39' => 'Spam',
    'volume39' => 'Volume',

    // 40-rep_top_recipient_domains_by_quantity.php
    'toprecipdomqt40' => 'Top des domaines de destination par quantité',
    'top10recipdomqt40' => 'Top 10 des domaines de destination par quantité',
    'domain40' => 'Domaine',
    'count40' => 'Nombre',
    'size40' => 'Taille',

    // 41-rep_top_recipient_domains_by_volume.php
    'toprecipdomvol41' => 'Top des domaines de destination par volume',
    'top10recipdomvol41' => 'Top 10 des domaines de destination par volume',
    'domain41' => 'Domaine',
    'count41' => 'Nombre',
    'size41' => 'Taille',

    // 42-rep_top_recipients_by_quantity.php
    'toprecipqt42' => 'Top des destinataires par quantité',
    'top10recipqt42' => 'Top 10 des destinataires par quantité',
    'email42' => 'Adresse E-Mail',
    'count42' => 'Nombre',
    'size42' => 'Taille',

    // 43-rep_top_recipients_by_volume.php
    'toprecipvol43' => 'Top des destinataires par volume',
    'top10recipvol43' => 'Top 10 des destinataires par volume',
    'email43' => 'Adresse E-Mail',
    'count43' => 'Nombre',
    'size43' => 'Taille',

    // 44-rep_top_sender_domains_by_quantity.php
    'topsenderdomqt44' => 'Top des domaines d\'expédition par quantité',
    'top10senderdomqt44' => 'Top 10 des domaines d\'expédition par quantité',
    'domain44' => 'Domaine',
    'count44' => 'Nombre',
    'size44' => 'Taille',

    // 45-rep_top_sender_domains_by_volume.php
    'topsenderdomvol45' => 'Top des domaines d\'expédition par volume',
    'top10senderdomvol45' => 'Top 10 des domaines d\'expédition par volume',
    'domain45' => 'Domaine',
    'count45' => 'Nombre',
    'size45' => 'Taille',

    // 46-rep_top_senders_by_quantity.php
    'topsendersqt46' => 'Top des expéditeurs par quantité',
    'top10sendersqt46' => 'Top 10 des expéditeurs par quantité',
    'email46' => 'Adresse E-Mail',
    'count46' => 'Nombre',
    'size46' => 'Taille',

    // 47-rep_top_senders_by_volume.php
    'topsendersvol47' => 'Top ders expéditeurs par volume',
    'top10sendersvol47' => 'Top 10 des expéditeurs par volume',
    'email47' => 'Adresse E-Mail',
    'count47' => 'Nombre',
    'size47' => 'Taille',

    // 48-rep_top_viruses.php
    'topvirus48' => 'Top des Virus',
    'top10virus48' => 'Top 10 des Virus',
    'nodata48' => 'Pas assez de données pour générer le graphique.',
    'virus48' => 'Virus',
    'count48' => 'Nombre',
    'dienorow48' => 'Erreur : aucun enregistrement trouvé dans la base de données...',

    // 49-rep_total_mail_by_date.php
    'totalmaildate49' => 'Total des messages par date',
    'totalmailprocdate49' => 'Total des messages traités par date',
    'volume49' => 'Volume',
    'nomessages49' => 'Nb de message',
    'date49' => 'Date',
    'barmail49' => 'Mail',
    'barvirus49' => 'Virus',
    'barspam49' => 'Spam',
    'barmcp49' => 'MCP',
    'barvolume49' => 'Volume',
    'message149' => 'Le fichier n\'est pas lisible. Vérifiez que le fichier File',
    'message249' => 'est lisible et peu être écrit par MailWatch',
    'total49' => 'Total<br>Mail',
    'clean49' => 'Légitime',
    'lowespam49' => 'Spam Bas',
    'highspam49' => 'Spam Haut',
    'blocked49' => 'Bloqué',
    'virus49' => 'Virus',
    'mcp49' => 'MCP',
    'unknoweusers49' => 'Utilisateurs<br>inconnus',
    'resolve49' => 'Impossible<br>à résoudre',
    'rbl49' => 'RBL',
    'totals49' => 'Total',

    // 50-rep_viruses.php
    'virusreport50' => 'Rapport sur les Virus',
    'virus50' => 'Virus',
    'scanner50' => 'Scanner',
    'firstseen50' => 'Date de première apparition',
    'count50' => 'Nombre',

    // 51-sa_lint.php
    'salint51' => 'SpamAssassin Lint',
    'diepipe51' => 'Impossible d\'ouvrir le conduit',

    // 52-sf_version.php
    'mwandmsversion52' => 'Information sur les versions des logiciels',

    // 53-sophos_status.php
    'sophos53' => 'Sophos',

    // 54-mailscanner_relay.php
    'diepipe54' => 'Impossible d\'ouvrir le conduit',

    // 55-msre_edit.php
    'diefnf55' => 'Le fichier suivant n\'a pas été trouvé :',

    // 56-postfix_relay.php
    'diepipe56' => 'Impossible d\'ouvrir le conduit',

    // 57-quarantine_action.php
    'dienoid57' => 'Erreur : pas de ID de message',
    'dienoaction57' => 'Erreur : aucune action',
    'diemnf57' => 'Erreur : aucun message trouvé en quarantaine',
    'dieuaction57' => 'Action inconnue :',

    // 58-viewpart.php
    'nomessid58' => 'Aucun ID de message saisie',
    'mess58' => 'Message',
    'notfound58' => 'non trouvé',
    'error58' => 'Erreur :',
    'errornfd58' => 'Erreur : fichier non trouvé',
    'part58' => 'Partie',

    //auto-release.php
    'msgnotfound1' => 'Message non trouvé. Vous avez déjà du libérer ce message ou le lien n\'est peut être plus bon.',
    'msgnotfound2' => 'Contactez votre administrateur de messagerie en lui indiquant ce numéro du message : ',
    'msgnotfound3' => 'si vous avez besoin de libérer ce message.',
    'msgreleased1' => 'Message libéré<br>Il faut attendre quelques minutes avant que le message apparaisse dans votre Boite aux lettres.',
    'tokenmismatch1' => 'Erreur pendant la libération du message - Erreur de Jeton',
    'notallowed99' => 'Vous n\êtes pas autorisé à accéder à cette page !',
    'dberror99' => 'Quelque-chose s\'est mal passé - Contactez le support',
    'arview01' => 'Afficher',
    'arrelease01' => 'Libérer',

    // 99 - General
    // Space rule for colon. Change it according to your langage typographical rule.
    'colon99' => ' :',
    'diemysql99' => 'Erreur : aucun enregistrement trouvé dans la base de données',
    'i18_missing' => 'Non traduit en français',
    'cannot_read_conf' => 'Impossible de lire le fichier conf.php - Créez un fichier de configuration conf.php à partir du fichier conf.php.example, et modifiez les paramètres de configuration comme nécessaire.',

);
