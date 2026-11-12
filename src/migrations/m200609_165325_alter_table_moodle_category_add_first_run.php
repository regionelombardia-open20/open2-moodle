<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-moodle
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

use open20\amos\core\migration\AmosMigration;
use open20\amos\moodle\models\MoodleCategory;

/**
 * m200609_165325_alter_table_moodle_category_add_first_run
 */
class m200609_165325_alter_table_moodle_category_add_first_run extends AmosMigration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            MoodleCategory::tableName(), 
            'first_run', 
            $this->integer()->notNull()->defaultValue(null)->comment('First run used to reset all community with e-learning')->after('community_id')
        );
        
        return true;
    }
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn(MoodleCategory::tableName(), 'first_run');
        
        return true;
    }
}