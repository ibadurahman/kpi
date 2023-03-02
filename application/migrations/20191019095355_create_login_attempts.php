<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_login_attempts extends CI_Migration
{

    /**
     * up (create table)
     *
     * @return void
     */
    public function up()
    {

        // Drop table login_attempts if it exists

        $this->dbforge->drop_table($this->tables["login_attempts"], TRUE);

        // Add Fields.
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
            ),
            'login' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
            ),
            'time' => array(
                'type' => 'INT',
                'constraint' => '11',
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

        // Create Table login_attempts
        $this->dbforge->create_table("login_attempts", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table login_attempts
        $this->dbforge->drop_table("login_attempts", TRUE);
    }

}
