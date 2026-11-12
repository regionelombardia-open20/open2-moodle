<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\tag
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */
use yii\db\Schema;
use yii\db\Migration;

/**
 * 
 */
class m200128_102025_create_table_paypal_transactions extends Migration
{
    /**
     * Bullet counter table
     * @var type 
     */
    protected $tableName;
    
    /**
     *
     * @var type 
     */
    protected $tableOptions;
    
    /**
     * @inheritdoc
     */
    public function init() {
        $this->tableName = '{{%paypal_transactions}}';
        $this->tableOptions = null;
    }

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * Table with bullets counter for single users and relative widget
         */
        if ($this->db->schema->getTableSchema($this->tableName, true) === null) {
            $this->createTable(
                $this->tableName,
                [
                    'id' => $this->primaryKey(),
                    'status' => $this->string()->notNull()->comment('Status (workflow)'),
                    'order_id' => $this->integer(),
                    'user_id' => $this->integer()->notNull()->comment('User that made payment'),
                    'total' => $this->float(),
                    'transaction_code' => $this->char(128)->notNull()->defaultValue(null)->comment('Paypal payment id'),
                    'token' => $this->char(128)->notNull()->defaultValue(null)->comment('Token from PayPal page'),
                    'type' => $this->char(128)->notNull()->comment('Type of payment'),
                    'wallet_id' => $this->string(),
                    
                    'created_at' => $this->dateTime(),
                    'updated_at' => $this->dateTime(),
                    'deleted_at' => $this->dateTime()->comment('Cancellato il'),
                    'created_by' => $this->integer(11)->defaultValue(null)->comment('Created by'),
                    'updated_by' => $this->integer(11)->defaultValue(null)->comment('Updated by'),
                    'deleted_by' => $this->integer(11)->defaultValue(null)->comment('Deleted by')
                ],
                $this->tableOptions
            );
            
        }
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable($this->tableName);
    }

}
