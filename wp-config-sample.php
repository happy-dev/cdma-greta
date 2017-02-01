<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */


// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'staging_cdmagreta');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'sylvia_k');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'laO9J4gRL4p8jFP99sbl');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'z,+ZDm~T%wTay#Nb46)JT9YO4/(bQu02X<$%(Sx(CBi<+Mh!Hb<hgzM*wVH<Z4n?');
define('SECURE_AUTH_KEY',  '4!.sCTd`?|9>18J#u<#{#11%lAmU6PHE#^y($E8A*&SX%30efI!8,~e.Vdy-q1j,');
define('LOGGED_IN_KEY',    ']@jx3oZeLXMl:B/*6r#}OI&~Q=_f1 4.B:a$(Hz{ezSpme#K,eqltP}FUs?V=&bt');
define('NONCE_KEY',        'gf1Jtml#tgdi+)$]Q{Tj}/}`S!*2b~?hI~n`ab&|AEB(+x8,>Ge$Rp51LhvPgXjp');
define('AUTH_SALT',        '5nE-ZTCP]s=1kP*EQS~>{ZB#}@$G)g0IZy=R,O(*|u7WJi3L+E[`LA*SIOOm{ vp');
define('SECURE_AUTH_SALT', '!>yt$cRrse(tq9[LTHTB-bks#vCr+2NByiriZ..9wH8Z/S1G+taqx&f8PD_Z~I*C');
define('LOGGED_IN_SALT',   'SIAK9>kb&F|A;I}e<J@lxg*$lN|L1ZNK)bIpl~uhQ(f5F@d0~t|=U0|CKi].,S!M');
define('NONCE_SALT',       'n$BITDyH*ov=t$H69TfjgO)-U&~M_#[m#-{PM,jh7.}1|.`k<jySr>GsZf]%c-?;');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'gretacdma_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d'information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define('FS_METHOD', 'direct');

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
