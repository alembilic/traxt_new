<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220118141526 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE active_guests (ip VARCHAR(15) NOT NULL, timestamp INT UNSIGNED NOT NULL, PRIMARY KEY(ip)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banlist (ban_id INT UNSIGNED AUTO_INCREMENT NOT NULL, ban_username VARCHAR(255) DEFAULT NULL, ban_userid INT UNSIGNED DEFAULT NULL, ban_ip VARCHAR(40) DEFAULT NULL, timestamp INT UNSIGNED NOT NULL, PRIMARY KEY(ban_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_log (id INT AUTO_INCREMENT NOT NULL, respons_code VARCHAR(11) NOT NULL, json_encoded_respons TEXT NOT NULL, id_imported_url INT NOT NULL, url VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bugs (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, imported_url_id INT NOT NULL, report TEXT NOT NULL, added DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, state INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bugs_external_links (id INT AUTO_INCREMENT NOT NULL, bug_id INT NOT NULL, id_imported_urls INT NOT NULL, dest_url TEXT DEFAULT NULL, anchortext VARCHAR(400) DEFAULT NULL, last_found DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, first_found DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, img_text INT DEFAULT NULL, ignore_link INT NOT NULL, rel_nofollow INT DEFAULT NULL, rel_sponsored INT DEFAULT NULL, rel_ugc INT DEFAULT NULL, found INT DEFAULT NULL, js_render INT NOT NULL, respons_code INT DEFAULT NULL, respons_last_checked DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, redirects INT NOT NULL, redirect_flow TEXT DEFAULT NULL, end_point TEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bugs_imported_urls (id INT AUTO_INCREMENT NOT NULL, bug_id INT NOT NULL, url VARCHAR(400) NOT NULL, last_checked DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, header_noindex INT NOT NULL, header_nofollow INT NOT NULL, head_noindex INT NOT NULL, head_nofollow INT NOT NULL, respons_code VARCHAR(11) NOT NULL, index_state INT NOT NULL, nohtml INT NOT NULL, manual_update_init INT DEFAULT NULL, last_index_check DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, waiting_index_respons INT NOT NULL, redirect_flow TEXT DEFAULT NULL, end_point VARCHAR(400) DEFAULT NULL, canonical INT NOT NULL, canonical_endpoint VARCHAR(250) NOT NULL, attempt INT NOT NULL, html LONGTEXT DEFAULT NULL, js_html LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuration (config_name VARCHAR(20) NOT NULL, config_value VARCHAR(64) NOT NULL, PRIMARY KEY(config_name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curl_error (id INT AUTO_INCREMENT NOT NULL, target_url VARCHAR(450) NOT NULL, error VARCHAR(450) NOT NULL, tstamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, erro_no INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deamon_handler (id INT AUTO_INCREMENT NOT NULL, unik_id VARCHAR(200) NOT NULL, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delay_log (id INT AUTO_INCREMENT NOT NULL, id_imported_urls INT NOT NULL, stamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, respons INT NOT NULL, known_link_count INT NOT NULL, INDEX id (id), INDEX id_imported_urls (id_imported_urls), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE external_links (id INT AUTO_INCREMENT NOT NULL, id_imported_urls INT NOT NULL, dest_url TEXT DEFAULT NULL, domain VARCHAR(1000) NOT NULL, anchortext VARCHAR(1500) DEFAULT NULL, last_found DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, first_found DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, img_text INT DEFAULT NULL, rel_nofollow INT DEFAULT NULL, rel_sponsored INT DEFAULT NULL, rel_ugc INT DEFAULT NULL, found INT DEFAULT NULL, js_render INT NOT NULL, respons_code INT DEFAULT NULL, respons_last_checked DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, redirects INT NOT NULL, redirect_flow TEXT DEFAULT NULL, end_point TEXT DEFAULT NULL, end_point_domain VARCHAR(1000) NOT NULL, INDEX id_imported_urls (id_imported_urls), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups (group_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, group_name VARCHAR(50) NOT NULL, group_level TINYINT(1) NOT NULL, PRIMARY KEY(group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ignore_links (id INT AUTO_INCREMENT NOT NULL, id_external_links BIGINT NOT NULL, ignore_link INT NOT NULL, user_id BIGINT NOT NULL, INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imported_urls (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(1000) NOT NULL, last_checked DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, header_noindex INT NOT NULL, header_nofollow INT NOT NULL, head_noindex INT NOT NULL, head_nofollow INT NOT NULL, respons_code VARCHAR(11) NOT NULL, index_state INT NOT NULL, nohtml INT NOT NULL, manual_update_init INT DEFAULT NULL, last_index_check DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, waiting_index_respons INT NOT NULL, redirect_flow TEXT DEFAULT NULL, end_point VARCHAR(1000) DEFAULT NULL, canonical INT NOT NULL, canonical_endpoint VARCHAR(1000) NOT NULL, attempt INT NOT NULL, index_result_url VARCHAR(1000) NOT NULL, end_point_domain VARCHAR(1000) NOT NULL, mem_use VARCHAR(22) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imported_urls_userdata (id INT AUTO_INCREMENT NOT NULL, id_imported_urls INT NOT NULL, comment VARCHAR(1000) NOT NULL, price VARCHAR(17) NOT NULL, user_id INT NOT NULL, id_valuta INT NOT NULL, INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE links (id INT AUTO_INCREMENT NOT NULL, id_imported_urls INT NOT NULL, user_id INT NOT NULL, INDEX id_imported_urls (id_imported_urls), INDEX user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_table (id INT UNSIGNED AUTO_INCREMENT NOT NULL, userid INT UNSIGNED NOT NULL, timestamp INT UNSIGNED NOT NULL, ip VARCHAR(15) NOT NULL, log_operation VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negativ_list (id INT AUTO_INCREMENT NOT NULL, domain VARCHAR(400) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message TEXT NOT NULL, stamp DATETIME NOT NULL, id_domain INT NOT NULL, status INT DEFAULT 1 NOT NULL, title VARCHAR(400) NOT NULL, mail INT NOT NULL, INDEX user_id_2 (user_id, id_domain), INDEX user_id (user_id, id_domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, subscriptions_orders_id VARCHAR(50) NOT NULL, product_id VARCHAR(50) NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, amount INT NOT NULL, next_payment_date DATE DEFAULT \'0000-00-00\' NOT NULL, card_withdraw INT DEFAULT NULL, transfer_state INT NOT NULL, vat INT NOT NULL, dinero_guid VARCHAR(50) NOT NULL, dinero_timestamp VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, productname VARCHAR(50) NOT NULL, price1 INT NOT NULL, comment TEXT NOT NULL, public INT NOT NULL, mix_id VARCHAR(50) NOT NULL, domains INT NOT NULL, links INT NOT NULL, renew1 INT NOT NULL, free_trail INT NOT NULL, index_service INT NOT NULL, price2 INT NOT NULL, renew2 INT NOT NULL, respons_code INT NOT NULL, manual_update INT DEFAULT NULL, render_service INT NOT NULL, canonical INT NOT NULL, bureau INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redirects (id INT AUTO_INCREMENT NOT NULL, id_external_links INT NOT NULL, dest_url VARCHAR(400) NOT NULL, redirects INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_delete (id INT AUTO_INCREMENT NOT NULL, sub_id VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriptions_orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, subscription_id VARCHAR(25) NOT NULL, product_id VARCHAR(50) NOT NULL, payment_link TEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_backlinks (id INT UNSIGNED AUTO_INCREMENT NOT NULL, source_url VARCHAR(191) DEFAULT NULL, dest_url VARCHAR(191) DEFAULT NULL, status INT NOT NULL, anchortext VARCHAR(191) DEFAULT NULL, created_by INT UNSIGNED NOT NULL, domain_id INT UNSIGNED NOT NULL, last_checked DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, last_found DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, first_found DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, link_type INT NOT NULL, ignore_link INT NOT NULL, tld_name VARCHAR(100) DEFAULT NULL, link_tld VARCHAR(100) DEFAULT NULL, deleted INT NOT NULL, created_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, img_text INT NOT NULL, header_noindex INT NOT NULL, header_nofollow INT NOT NULL, head_noindex INT NOT NULL, head_nofollow INT NOT NULL, rel_nofollow INT NOT NULL, rel_sponsored INT NOT NULL, rel_ugc INT NOT NULL, respons VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_crons (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cronJobId CHAR(36) NOT NULL, handleId INT NOT NULL, handleType INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_dbcache (id INT UNSIGNED AUTO_INCREMENT NOT NULL, url VARCHAR(191) NOT NULL, html LONGTEXT NOT NULL, md5 VARCHAR(191) NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, created_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, respons_code VARCHAR(11) DEFAULT NULL, UNIQUE INDEX dbcache_url_unique (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_domain_groups (id INT AUTO_INCREMENT NOT NULL, group_name VARCHAR(100) NOT NULL, user_id INT NOT NULL, group_type INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_domain_groups_list (id INT AUTO_INCREMENT NOT NULL, domain_id INT NOT NULL, domain_group_id INT NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_domains (id INT UNSIGNED AUTO_INCREMENT NOT NULL, domain_name VARCHAR(191) NOT NULL, domain_url VARCHAR(191) DEFAULT NULL, domain_alias VARCHAR(100) DEFAULT NULL, parent_id INT NOT NULL, domain_type VARCHAR(191) NOT NULL, created_by INT UNSIGNED NOT NULL, thumb_url VARCHAR(100) DEFAULT NULL, domain_status INT DEFAULT 1 NOT NULL, show_dash INT NOT NULL, deleted INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, validate INT DEFAULT 1 NOT NULL, respons_code INT DEFAULT NULL, domain_end_point VARCHAR(1000) NOT NULL, domain_redirect_flow TEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_invite_templates (id INT AUTO_INCREMENT NOT NULL, template_name VARCHAR(255) NOT NULL, template_desc TEXT DEFAULT NULL, created_by INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_link_o_domains_list (id INT AUTO_INCREMENT NOT NULL, link_group_id INT NOT NULL, domain_id INT NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_link_o_groups (id INT UNSIGNED AUTO_INCREMENT NOT NULL, group_name VARCHAR(100) NOT NULL, user_id INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_link_o_groups_list (id INT AUTO_INCREMENT NOT NULL, link_group_id INT NOT NULL, overview_id INT NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_overview_groups (id INT UNSIGNED AUTO_INCREMENT NOT NULL, group_name VARCHAR(100) NOT NULL, user_id INT NOT NULL, group_type INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_overview_groups_list (id INT AUTO_INCREMENT NOT NULL, domain_id INT NOT NULL, domain_group_id INT NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_planning_groups (id INT UNSIGNED AUTO_INCREMENT NOT NULL, group_name VARCHAR(100) NOT NULL, user_id INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_planning_groups_list (id INT AUTO_INCREMENT NOT NULL, link_id INT NOT NULL, link_group_id INT NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_planning_links (id INT UNSIGNED AUTO_INCREMENT NOT NULL, link_name VARCHAR(191) DEFAULT NULL, link_url VARCHAR(191) DEFAULT NULL, status INT NOT NULL, created_by INT UNSIGNED NOT NULL, domain_id INT UNSIGNED NOT NULL, link_type INT NOT NULL, tld_name VARCHAR(100) DEFAULT NULL, price DOUBLE PRECISION DEFAULT \'0.00\' NOT NULL, notes TEXT DEFAULT NULL, dr_number INT NOT NULL, traffic INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trx_proxies (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(191) NOT NULL, port VARCHAR(191) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, location VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_sessions (id INT UNSIGNED AUTO_INCREMENT NOT NULL, session_id CHAR(32) NOT NULL, hashedValidator CHAR(64) NOT NULL, persistent TINYINT(1) NOT NULL, userid INT UNSIGNED NOT NULL, ipaddress VARCHAR(15) NOT NULL, timestamp INT UNSIGNED NOT NULL, expires INT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_temp (id INT UNSIGNED AUTO_INCREMENT NOT NULL, userid INT UNSIGNED NOT NULL, timestamp INT UNSIGNED NOT NULL, type VARCHAR(20) NOT NULL, detail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, firstname VARCHAR(40) NOT NULL, lastname VARCHAR(40) NOT NULL, password VARCHAR(255) DEFAULT NULL, userlevel TINYINT(1) NOT NULL, email VARCHAR(50) DEFAULT NULL, timestamp VARCHAR(50) NOT NULL, previous_visit INT UNSIGNED DEFAULT NULL, ip VARCHAR(15) NOT NULL, regdate VARCHAR(50) NOT NULL, lastip VARCHAR(15) DEFAULT NULL, user_login_attempts TINYINT(1) DEFAULT NULL, user_home_path VARCHAR(50) DEFAULT NULL, company VARCHAR(50) NOT NULL, vat_number VARCHAR(25) NOT NULL, country VARCHAR(50) NOT NULL, address VARCHAR(50) NOT NULL, city VARCHAR(75) NOT NULL, id_owner INT NOT NULL, lang VARCHAR(45) DEFAULT \'en-US\' NOT NULL, plan VARCHAR(50) NOT NULL, renew VARCHAR(11) NOT NULL, sub_id VARCHAR(50) NOT NULL, active_plan INT NOT NULL, next_due_date DATE DEFAULT \'0000-00-00\' NOT NULL, vat_valid VARCHAR(10) NOT NULL, dinero_add_guid VARCHAR(50) NOT NULL, old_user INT NOT NULL, sub_table_id INT NOT NULL, id_valuta INT DEFAULT 31 NOT NULL, id_valuta_display INT DEFAULT 31 NOT NULL, id_bureau INT NOT NULL, INDEX username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_groups (id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, group_id SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valuta (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(11) NOT NULL, value NUMERIC(17, 2) NOT NULL, INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE active_guests');
        $this->addSql('DROP TABLE banlist');
        $this->addSql('DROP TABLE bug_log');
        $this->addSql('DROP TABLE bugs');
        $this->addSql('DROP TABLE bugs_external_links');
        $this->addSql('DROP TABLE bugs_imported_urls');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE curl_error');
        $this->addSql('DROP TABLE deamon_handler');
        $this->addSql('DROP TABLE delay_log');
        $this->addSql('DROP TABLE external_links');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP TABLE ignore_links');
        $this->addSql('DROP TABLE imported_urls');
        $this->addSql('DROP TABLE imported_urls_userdata');
        $this->addSql('DROP TABLE links');
        $this->addSql('DROP TABLE log_table');
        $this->addSql('DROP TABLE negativ_list');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE redirects');
        $this->addSql('DROP TABLE subscription_delete');
        $this->addSql('DROP TABLE subscriptions_orders');
        $this->addSql('DROP TABLE trx_backlinks');
        $this->addSql('DROP TABLE trx_crons');
        $this->addSql('DROP TABLE trx_dbcache');
        $this->addSql('DROP TABLE trx_domain_groups');
        $this->addSql('DROP TABLE trx_domain_groups_list');
        $this->addSql('DROP TABLE trx_domains');
        $this->addSql('DROP TABLE trx_invite_templates');
        $this->addSql('DROP TABLE trx_link_o_domains_list');
        $this->addSql('DROP TABLE trx_link_o_groups');
        $this->addSql('DROP TABLE trx_link_o_groups_list');
        $this->addSql('DROP TABLE trx_overview_groups');
        $this->addSql('DROP TABLE trx_overview_groups_list');
        $this->addSql('DROP TABLE trx_planning_groups');
        $this->addSql('DROP TABLE trx_planning_groups_list');
        $this->addSql('DROP TABLE trx_planning_links');
        $this->addSql('DROP TABLE trx_proxies');
        $this->addSql('DROP TABLE user_sessions');
        $this->addSql('DROP TABLE user_temp');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('DROP TABLE valuta');
    }
}
