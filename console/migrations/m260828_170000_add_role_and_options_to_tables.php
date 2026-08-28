<?php

use yii\db\Migration;

/**
 * Handles adding role to user table and quiz options to question table.
 */
class m260828_170000_add_role_and_options_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Add role column to user table if not exists
        $userTable = $this->db->schema->getTableSchema('{{%user}}');
        if ($userTable && !isset($userTable->columns['role'])) {
            $this->addColumn('{{%user}}', 'role', $this->string(20)->notNull()->defaultValue('user')->after('email'));
            // Set existing users to admin so the project owner is not locked out
            $this->update('{{%user}}', ['role' => 'admin']);
        }

        // 2. Add quiz option columns to question table
        $questionTable = $this->db->schema->getTableSchema('{{%question}}');
        if ($questionTable) {
            if (!isset($questionTable->columns['type'])) {
                $this->addColumn('{{%question}}', 'type', $this->string(20)->notNull()->defaultValue('open')->after('category_id'));
            }
            if (!isset($questionTable->columns['option_a'])) {
                $this->addColumn('{{%question}}', 'option_a', $this->string(255)->null()->after('question_text'));
            }
            if (!isset($questionTable->columns['option_b'])) {
                $this->addColumn('{{%question}}', 'option_b', $this->string(255)->null()->after('option_a'));
            }
            if (!isset($questionTable->columns['option_c'])) {
                $this->addColumn('{{%question}}', 'option_c', $this->string(255)->null()->after('option_b'));
            }
            if (!isset($questionTable->columns['option_d'])) {
                $this->addColumn('{{%question}}', 'option_d', $this->string(255)->null()->after('option_c'));
            }
            if (!isset($questionTable->columns['correct_option'])) {
                $this->addColumn('{{%question}}', 'correct_option', $this->string(10)->null()->after('option_d'));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $questionTable = $this->db->schema->getTableSchema('{{%question}}');
        if ($questionTable) {
            if (isset($questionTable->columns['correct_option'])) {
                $this->dropColumn('{{%question}}', 'correct_option');
            }
            if (isset($questionTable->columns['option_d'])) {
                $this->dropColumn('{{%question}}', 'option_d');
            }
            if (isset($questionTable->columns['option_c'])) {
                $this->dropColumn('{{%question}}', 'option_c');
            }
            if (isset($questionTable->columns['option_b'])) {
                $this->dropColumn('{{%question}}', 'option_b');
            }
            if (isset($questionTable->columns['option_a'])) {
                $this->dropColumn('{{%question}}', 'option_a');
            }
            if (isset($questionTable->columns['type'])) {
                $this->dropColumn('{{%question}}', 'type');
            }
        }

        $userTable = $this->db->schema->getTableSchema('{{%user}}');
        if ($userTable && isset($userTable->columns['role'])) {
            $this->dropColumn('{{%user}}', 'role');
        }
    }
}
