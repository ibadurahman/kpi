<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_tes extends CI_Migration
{

    /**
     * up (create table)
     *
     * @return void
     */
    public function up()
    {

        // Drop table tes if it exists

        $this->dbforge->drop_table($this->tables["tes"], TRUE);

        // Add Fields.
        $this->dbforge->add_field(array(
            'kd_tes' => array(
                'type' => 'INT',
                'constraint' => '10',
                'unsigned' => TRUE,
            ),
            'nm_tes' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ),
        ));

        // Add Primary Key.
        $this->dbforge->add_key("kd_tes", TRUE);

        // Table attributes.

        $attributes = array(
            'ENGINE' => 'InnoDB',
        );

        // Create Table tes
        $this->dbforge->create_table("tes", TRUE, $attributes);

    }

    /**
     * down (drop table)
     *
     * @return void
     */
    public function down()
    {
        // Drop table tes
        $this->dbforge->drop_table("tes", TRUE);
    }

}
