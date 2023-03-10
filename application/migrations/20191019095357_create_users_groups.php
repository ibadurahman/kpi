<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_users_groups extends CI_Migration
{

    /**
     * up (create table)
     *
     * @return void
     */
    public function up()
    {

        // Drop table users_groups if it exists

        $this->dbforge->drop_table($this->tables["users_groups"], TRUE);

        // Add Fields.
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
            ),
            'user_id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'group_id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("id", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table users_groups
        $this->dbforge->create_table("users_groups", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table users_groups
        $this->dbforge->drop_table("users_groups", TRUE);
    }

}
