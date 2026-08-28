<?php

use yii\db\Migration;

/**
 * Converts all tables and columns to utf8mb4 for full emoji support.
 */
class m260828_180000_convert_tables_to_utf8mb4 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tables = ['category', 'question', 'site_setting', 'user'];
        foreach ($tables as $t) {
            $tableName = $this->db->schema->getRawTableName("{{%{$t}}}");
            $this->execute("ALTER TABLE `{$tableName}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tables = ['category', 'question', 'site_setting', 'user'];
        foreach ($tables as $t) {
            $tableName = $this->db->schema->getRawTableName("{{%{$t}}}");
            $this->execute("ALTER TABLE `{$tableName}` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci");
        }
    }
}
