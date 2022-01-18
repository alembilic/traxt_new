<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220118141600 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE active_guests CHANGE ip ip VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE banlist CHANGE ban_username ban_username VARCHAR(255) DEFAULT NULL, CHANGE ban_userid ban_userid INT UNSIGNED DEFAULT NULL, CHANGE ban_ip ban_ip VARCHAR(40) DEFAULT NULL');
        $this->addSql('ALTER TABLE bugs CHANGE state state INT NOT NULL');
        $this->addSql('ALTER TABLE bugs_external_links CHANGE ignore_link ignore_link INT NOT NULL, CHANGE js_render js_render INT NOT NULL, CHANGE redirects redirects INT NOT NULL');
        $this->addSql('ALTER TABLE bugs_imported_urls CHANGE header_noindex header_noindex INT NOT NULL, CHANGE header_nofollow header_nofollow INT NOT NULL, CHANGE head_noindex head_noindex INT NOT NULL, CHANGE head_nofollow head_nofollow INT NOT NULL, CHANGE respons_code respons_code VARCHAR(11) NOT NULL, CHANGE index_state index_state INT NOT NULL, CHANGE nohtml nohtml INT NOT NULL, CHANGE manual_update_init manual_update_init INT DEFAULT NULL, CHANGE waiting_index_respons waiting_index_respons INT NOT NULL, CHANGE canonical canonical INT NOT NULL, CHANGE canonical_endpoint canonical_endpoint VARCHAR(250) NOT NULL, CHANGE attempt attempt INT NOT NULL');
        $this->addSql('ALTER TABLE configuration CHANGE config_name config_name VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE external_links CHANGE domain domain VARCHAR(1000) NOT NULL, CHANGE js_render js_render INT NOT NULL, CHANGE redirects redirects INT NOT NULL, CHANGE end_point_domain end_point_domain VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE groups CHANGE group_level group_level TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE imported_urls CHANGE header_noindex header_noindex INT NOT NULL, CHANGE header_nofollow header_nofollow INT NOT NULL, CHANGE head_noindex head_noindex INT NOT NULL, CHANGE head_nofollow head_nofollow INT NOT NULL, CHANGE respons_code respons_code VARCHAR(11) NOT NULL, CHANGE index_state index_state INT NOT NULL, CHANGE nohtml nohtml INT NOT NULL, CHANGE manual_update_init manual_update_init INT DEFAULT NULL, CHANGE waiting_index_respons waiting_index_respons INT NOT NULL, CHANGE canonical canonical INT NOT NULL, CHANGE canonical_endpoint canonical_endpoint VARCHAR(1000) NOT NULL, CHANGE attempt attempt INT NOT NULL, CHANGE index_result_url index_result_url VARCHAR(1000) NOT NULL, CHANGE end_point_domain end_point_domain VARCHAR(1000) NOT NULL, CHANGE mem_use mem_use VARCHAR(22) NOT NULL');
        $this->addSql('ALTER TABLE notifications CHANGE mail mail INT NOT NULL');
        $this->addSql('ALTER TABLE orders CHANGE card_withdraw card_withdraw INT DEFAULT NULL, CHANGE transfer_state transfer_state INT NOT NULL, CHANGE vat vat INT NOT NULL, CHANGE dinero_guid dinero_guid VARCHAR(50) NOT NULL, CHANGE dinero_timestamp dinero_timestamp VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE products CHANGE respons_code respons_code INT NOT NULL, CHANGE manual_update manual_update INT DEFAULT NULL, CHANGE render_service render_service INT NOT NULL, CHANGE canonical canonical INT NOT NULL, CHANGE bureau bureau INT NOT NULL');
        $this->addSql('ALTER TABLE subscriptions_orders CHANGE subscription_id subscription_id VARCHAR(25) NOT NULL, CHANGE product_id product_id VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE trx_backlinks CHANGE status status INT NOT NULL, CHANGE domain_id domain_id INT UNSIGNED NOT NULL, CHANGE link_type link_type INT NOT NULL, CHANGE ignore_link ignore_link INT NOT NULL, CHANGE deleted deleted INT NOT NULL, CHANGE header_noindex header_noindex INT NOT NULL, CHANGE header_nofollow header_nofollow INT NOT NULL, CHANGE rel_nofollow rel_nofollow INT NOT NULL, CHANGE rel_sponsored rel_sponsored INT NOT NULL, CHANGE rel_ugc rel_ugc INT NOT NULL');
        $this->addSql('ALTER TABLE trx_domain_groups CHANGE group_type group_type INT NOT NULL');
        $this->addSql('ALTER TABLE trx_domain_groups_list CHANGE domain_id domain_id INT NOT NULL, CHANGE domain_group_id domain_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE trx_domains CHANGE parent_id parent_id INT NOT NULL, CHANGE show_dash show_dash INT NOT NULL, CHANGE deleted deleted INT NOT NULL, CHANGE domain_end_point domain_end_point VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE trx_invite_templates CHANGE created_by created_by INT NOT NULL');
        $this->addSql('ALTER TABLE trx_link_o_domains_list CHANGE link_group_id link_group_id INT NOT NULL, CHANGE domain_id domain_id INT NOT NULL');
        $this->addSql('ALTER TABLE trx_link_o_groups_list CHANGE link_group_id link_group_id INT NOT NULL, CHANGE overview_id overview_id INT NOT NULL');
        $this->addSql('ALTER TABLE trx_overview_groups CHANGE group_type group_type INT NOT NULL');
        $this->addSql('ALTER TABLE trx_overview_groups_list CHANGE domain_id domain_id INT NOT NULL, CHANGE domain_group_id domain_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE trx_planning_groups_list CHANGE link_id link_id INT NOT NULL, CHANGE link_group_id link_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE trx_planning_links CHANGE link_type link_type INT NOT NULL, CHANGE dr_number dr_number INT NOT NULL, CHANGE traffic traffic INT NOT NULL');
        $this->addSql('ALTER TABLE user_sessions CHANGE persistent persistent TINYINT(1) NOT NULL, CHANGE ipaddress ipaddress VARCHAR(15) NOT NULL, CHANGE timestamp timestamp INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE userlevel userlevel TINYINT(1) NOT NULL, CHANGE previous_visit previous_visit INT UNSIGNED DEFAULT NULL, CHANGE id_owner id_owner INT NOT NULL, CHANGE renew renew VARCHAR(11) NOT NULL, CHANGE sub_id sub_id VARCHAR(50) NOT NULL, CHANGE active_plan active_plan INT NOT NULL, CHANGE vat_valid vat_valid VARCHAR(10) NOT NULL, CHANGE dinero_add_guid dinero_add_guid VARCHAR(50) NOT NULL, CHANGE old_user old_user INT NOT NULL, CHANGE sub_table_id sub_table_id INT NOT NULL, CHANGE id_bureau id_bureau INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE active_guests CHANGE ip ip VARCHAR(15) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE banlist CHANGE ban_username ban_username VARCHAR(255) CHARACTER SET utf8 DEFAULT \'0\' COLLATE `utf8_general_ci`, CHANGE ban_userid ban_userid INT UNSIGNED DEFAULT 0, CHANGE ban_ip ban_ip VARCHAR(40) CHARACTER SET utf8 DEFAULT \'0\' COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE bugs CHANGE state state INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE bugs_external_links CHANGE ignore_link ignore_link INT DEFAULT 0 NOT NULL, CHANGE js_render js_render INT DEFAULT 0 NOT NULL, CHANGE redirects redirects INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE bugs_imported_urls CHANGE header_noindex header_noindex INT DEFAULT 0 NOT NULL, CHANGE header_nofollow header_nofollow INT DEFAULT 0 NOT NULL, CHANGE head_noindex head_noindex INT DEFAULT 0 NOT NULL, CHANGE head_nofollow head_nofollow INT DEFAULT 0 NOT NULL, CHANGE respons_code respons_code VARCHAR(11) CHARACTER SET utf8 DEFAULT \'0\' NOT NULL COLLATE `utf8_general_ci`, CHANGE index_state index_state INT DEFAULT 0 NOT NULL, CHANGE nohtml nohtml INT DEFAULT 0 NOT NULL, CHANGE manual_update_init manual_update_init INT DEFAULT 0, CHANGE waiting_index_respons waiting_index_respons INT DEFAULT 0 NOT NULL, CHANGE canonical canonical INT DEFAULT 0 NOT NULL, CHANGE canonical_endpoint canonical_endpoint VARCHAR(250) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE attempt attempt INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE configuration CHANGE config_name config_name VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE external_links CHANGE domain domain VARCHAR(1000) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE js_render js_render INT DEFAULT 0 NOT NULL, CHANGE redirects redirects INT DEFAULT 0 NOT NULL, CHANGE end_point_domain end_point_domain VARCHAR(1000) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE groups CHANGE group_level group_level TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE imported_urls CHANGE header_noindex header_noindex INT DEFAULT 0 NOT NULL, CHANGE header_nofollow header_nofollow INT DEFAULT 0 NOT NULL, CHANGE head_noindex head_noindex INT DEFAULT 0 NOT NULL, CHANGE head_nofollow head_nofollow INT DEFAULT 0 NOT NULL, CHANGE respons_code respons_code VARCHAR(11) CHARACTER SET utf8 DEFAULT \'0\' NOT NULL COLLATE `utf8_general_ci`, CHANGE index_state index_state INT DEFAULT 0 NOT NULL, CHANGE nohtml nohtml INT DEFAULT 0 NOT NULL, CHANGE manual_update_init manual_update_init INT DEFAULT 0, CHANGE waiting_index_respons waiting_index_respons INT DEFAULT 0 NOT NULL, CHANGE canonical canonical INT DEFAULT 0 NOT NULL, CHANGE canonical_endpoint canonical_endpoint VARCHAR(1000) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE attempt attempt INT DEFAULT 0 NOT NULL, CHANGE index_result_url index_result_url VARCHAR(1000) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE end_point_domain end_point_domain VARCHAR(1000) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE mem_use mem_use VARCHAR(22) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE notifications CHANGE mail mail INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE orders CHANGE card_withdraw card_withdraw INT DEFAULT 0, CHANGE transfer_state transfer_state INT DEFAULT 0 NOT NULL, CHANGE vat vat INT DEFAULT 0 NOT NULL, CHANGE dinero_guid dinero_guid VARCHAR(50) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE dinero_timestamp dinero_timestamp VARCHAR(50) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE products CHANGE respons_code respons_code INT DEFAULT 0 NOT NULL, CHANGE manual_update manual_update INT DEFAULT 0, CHANGE render_service render_service INT DEFAULT 0 NOT NULL, CHANGE canonical canonical INT DEFAULT 0 NOT NULL, CHANGE bureau bureau INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE subscriptions_orders CHANGE subscription_id subscription_id VARCHAR(25) CHARACTER SET utf8 DEFAULT \'0\' NOT NULL COLLATE `utf8_general_ci`, CHANGE product_id product_id VARCHAR(50) CHARACTER SET utf8 DEFAULT \'0\' NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE trx_backlinks CHANGE status status INT DEFAULT 0 NOT NULL, CHANGE domain_id domain_id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE link_type link_type INT DEFAULT 0 NOT NULL, CHANGE ignore_link ignore_link INT DEFAULT 0 NOT NULL, CHANGE deleted deleted INT DEFAULT 0 NOT NULL, CHANGE header_noindex header_noindex INT DEFAULT 0 NOT NULL, CHANGE header_nofollow header_nofollow INT DEFAULT 0 NOT NULL, CHANGE rel_nofollow rel_nofollow INT DEFAULT 0 NOT NULL, CHANGE rel_sponsored rel_sponsored INT DEFAULT 0 NOT NULL, CHANGE rel_ugc rel_ugc INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_domain_groups CHANGE group_type group_type INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_domain_groups_list CHANGE domain_id domain_id INT DEFAULT 0 NOT NULL, CHANGE domain_group_id domain_group_id INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_domains CHANGE parent_id parent_id INT DEFAULT 0 NOT NULL, CHANGE show_dash show_dash INT DEFAULT 0 NOT NULL, CHANGE deleted deleted INT DEFAULT 0 NOT NULL, CHANGE domain_end_point domain_end_point VARCHAR(1000) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE trx_invite_templates CHANGE created_by created_by INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_link_o_domains_list CHANGE link_group_id link_group_id INT DEFAULT 0 NOT NULL, CHANGE domain_id domain_id INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_link_o_groups_list CHANGE link_group_id link_group_id INT DEFAULT 0 NOT NULL, CHANGE overview_id overview_id INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_overview_groups CHANGE group_type group_type INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_overview_groups_list CHANGE domain_id domain_id INT DEFAULT 0 NOT NULL, CHANGE domain_group_id domain_group_id INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_planning_groups_list CHANGE link_id link_id INT DEFAULT 0 NOT NULL, CHANGE link_group_id link_group_id INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE trx_planning_links CHANGE link_type link_type INT DEFAULT 0 NOT NULL, CHANGE dr_number dr_number INT DEFAULT 0 NOT NULL, CHANGE traffic traffic INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user_sessions CHANGE persistent persistent TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE ipaddress ipaddress VARCHAR(15) CHARACTER SET utf8 DEFAULT \'0\' NOT NULL COLLATE `utf8_general_ci`, CHANGE timestamp timestamp INT UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE userlevel userlevel TINYINT(1) NOT NULL, CHANGE previous_visit previous_visit INT UNSIGNED DEFAULT 0, CHANGE id_owner id_owner INT DEFAULT 0 NOT NULL, CHANGE renew renew VARCHAR(11) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE sub_id sub_id VARCHAR(50) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE active_plan active_plan INT DEFAULT 0 NOT NULL, CHANGE vat_valid vat_valid VARCHAR(10) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE dinero_add_guid dinero_add_guid VARCHAR(50) CHARACTER SET utf8 DEFAULT \'\' NOT NULL COLLATE `utf8_general_ci`, CHANGE old_user old_user INT DEFAULT 0 NOT NULL, CHANGE sub_table_id sub_table_id INT DEFAULT 0 NOT NULL, CHANGE id_bureau id_bureau INT DEFAULT 0 NOT NULL');
    }
}
